import 'dart:convert';
import 'package:bluetooth_print/bluetooth_print.dart';
import 'package:bluetooth_print/bluetooth_print_model.dart';
import 'package:directprint/models/printer.dart';
import 'package:http/http.dart';
import 'package:intl/intl.dart';
import 'package:flutter/material.dart';

Future<void> testprintReciept(BluetoothPrint bluetoothPrint, String data) async {
  print(data);
  Map<dynamic, dynamic> oData = jsonDecode(data);
  print("print Reciepta : " + oData["NoTRX"]);

  int MaxChar = 0;
  int MaxItemName = 0;

  int MaxLength0 = 0;
  int MaxLength1 = 0;
  int MaxLength2 = 0;
  int MaxLength3 = 0;

  int CheckPoint0 = 0;
  int CheckPoint1 = 0;
  int CheckPoint2 = 0;
  int CheckPoint3 = 0;

  int HargaJualInitialSpace = 0;
  int MaxHargaJualSpaceBetwen = 0;

  if (oData['PrinterWidth'] == 48) {
    MaxChar = 32;
    MaxItemName = 13;
    HargaJualInitialSpace = 9;
    MaxHargaJualSpaceBetwen = 9;

    MaxLength0 = 12;
    MaxLength1 = 2;
    MaxLength2 = 6;
    MaxLength3 = 9;

    CheckPoint0 = 12;
    CheckPoint1 = 15;
    CheckPoint2 = 22;
    CheckPoint3 = 32;
  }
  else if(oData['PrinterWidth'] == 80){
    MaxChar = 48;

    MaxItemName = 13;
    HargaJualInitialSpace = 9;
    MaxHargaJualSpaceBetwen = 16;

    MaxLength0 = 16;
    MaxLength1 = 6;
    MaxLength2 = 10;
    MaxLength3 = 13;

    CheckPoint0 = 28;
    CheckPoint1 = 31;
    CheckPoint2 = 38;
    CheckPoint3 = 48;
  }
  Map<String, dynamic> config = Map();
  config['width'] = oData['PrinterWidth']; // 标签宽度，单位mm
  config['height'] = 28; // 标签高度，单位mm
  config['gap'] = 2; // 标签间隔，单位mm

  // print(snapshot.data!["data"]);
  DateTime now = DateTime.now();
  String formattedDateTime = DateFormat('yyyy-MM-dd HH:mm:ss').format(now);

  List<LineText> list = [];
  if (oData["Logo"] != "") {
    list.add(LineText(type: LineText.TYPE_IMAGE,content: oData["Logo"],size: 20,align: LineText.ALIGN_CENTER,linefeed: 1));
  }
  list.add(LineText(type: LineText.TYPE_TEXT,content: oData["CompanyName"],weight: 2,width: 12,align: LineText.ALIGN_CENTER,linefeed: 1));
  list.add(LineText(type: LineText.TYPE_TEXT,content: oData["CompanyAddress"],weight: 0,align: LineText.ALIGN_CENTER,linefeed: 1));
  list.add(LineText(linefeed: 1));
  list.add(LineText(type: LineText.TYPE_TEXT,content: "-" * MaxChar,weight: 0,align: LineText.ALIGN_CENTER,linefeed: 1));

  String header = "";
  String Tanggal = oData["TglTransaksi"];
  String Kasir = "Kasir :" + oData["Kasir"];
  int spaceGap = MaxChar - Tanggal.length - Kasir.length;

  header = Tanggal + (" " * spaceGap) + Kasir;

  list.add(LineText(type: LineText.TYPE_TEXT,content: header,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  list.add(LineText(type: LineText.TYPE_TEXT,content: "-" * MaxChar,weight: 0,align: LineText.ALIGN_CENTER,linefeed: 1));

  String tempText = "";
  String LastItem = "";
  String Qty = "";
  String harga = "";
  String Total = "";

  int space1 = 0;
  int space2 = 0;
  int space3 = 0;
  int space4 = 0;

  for (var i = 0; i < oData["Detail"].length; i++) {
    String NamaItem = oData["Detail"][i]["Item"].toString().substring(0, oData["Detail"][i]["Item"].toString().length < MaxLength0 ? oData["Detail"][i]["Item"].toString().length : MaxLength0);
    // Item
    space1 = (CheckPoint0 - NamaItem.length) +1;
    tempText = NamaItem +(" " * space1);
    // End Item

    // Qty
    space2 = CheckPoint1 -(tempText.length + oData["Detail"][i]["Qty"].toString().length);
    tempText = tempText + (" " * space2) + oData["Detail"][i]["Qty"].toString();
    // End Qty

    // Harga
    space3 = CheckPoint2 - (tempText.length + oData["Detail"][i]["Harga"].toString().length);
    tempText =tempText + (" " * space3) + oData["Detail"][i]["Harga"].toString();
    // End Harga

    // Total
    space4 = CheckPoint3 -(tempText.length + oData["Detail"][i]["Total"].toString().length);
    tempText = tempText + (" " * space4) + oData["Detail"][i]["Total"].toString();
    // End Total

    print(tempText);
    list.add(LineText(type: LineText.TYPE_TEXT,content: tempText ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  }
  
  int lineSpace = MaxLength3 + MaxLength2 + MaxLength1;
  list.add(LineText(type: LineText.TYPE_TEXT,content: "-" * lineSpace ,weight: 0,align: LineText.ALIGN_RIGHT,linefeed: 1));

  // Sub Total
  String HargaJualText = "HARGA JUAL";

  int SubTotalLenth = MaxChar - MaxHargaJualSpaceBetwen - HargaJualText.length -  (oData["SubTotal"]).toString().length;
  String SubTotal = " " * HargaJualInitialSpace + HargaJualText + " " * SubTotalLenth + oData["SubTotal"];
  list.add(LineText(type: LineText.TYPE_TEXT,content: SubTotal ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  
  print(SubTotal);
  // Diskon
  for (var i = 0; i < oData["Detail"].length; i++) {
    if(oData["Detail"][i]["Diskon"] != "0"){
      // print((HargaJualInitialSpace + HargaJualText.length).toString() + " > " + oData["Detail"][i]["Item"].toString().toString().length.toString());
      String item = oData["Detail"][i]["Item"].toString().substring(0, oData["Detail"][i]["Item"].toString().length < (HargaJualInitialSpace + HargaJualText.length) ?oData["Detail"][i]["Item"].toString().length : (HargaJualInitialSpace + HargaJualText.length));
      int diskonInitSpace = MaxChar - item.length - HargaJualText.length - (item.length - HargaJualText.length + 1);
      int diskonBetweenlenth = MaxChar - MaxHargaJualSpaceBetwen - SubTotalLenth - oData["Detail"][i]["Diskon"].toString().length - oData["Detail"][i]["SubTotal"].toString().length;
      // diskonBetweenlenth = MaxChar - MaxHargaJualSpaceBetwen - item.length - oData["Detail"][i]["Diskon"].toString().length;
      String Diskon = " " * (diskonInitSpace) + item + " " * diskonBetweenlenth + oData["Detail"][i]["Diskon"].toString();
      list.add(LineText(type: LineText.TYPE_TEXT,content: Diskon ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));

      print(Diskon);
    }
  }
  list.add(LineText(type: LineText.TYPE_TEXT,content: "-" * lineSpace ,weight: 0,align: LineText.ALIGN_RIGHT,linefeed: 1));

  String Summary1 = "TOTAL";
  String Summary2 = oData["MetodeBayar"];
  String Summary3 = "KEMBALI";
  String Summary4 = "ANDA HEMAT";

  int Summary = MaxChar - MaxHargaJualSpaceBetwen - Summary1.length  -  (oData["GrandTotal"]).toString().length;
  String SummaryText = " " * (HargaJualInitialSpace) + Summary1 + " " * Summary + oData["GrandTotal"];
  list.add(LineText(type: LineText.TYPE_TEXT,content: SummaryText ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  print(SummaryText);

  Summary = MaxChar - MaxHargaJualSpaceBetwen - Summary2.length -  (oData["TotalBayar"]).toString().length;
  SummaryText = " " * (HargaJualInitialSpace) + Summary2 + " " * Summary + oData["TotalBayar"];
  list.add(LineText(type: LineText.TYPE_TEXT,content: SummaryText ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  print(SummaryText);

  Summary = MaxChar - MaxHargaJualSpaceBetwen - Summary3.length -  (oData["Kembalian"]).toString().length;
  SummaryText = " " * (HargaJualInitialSpace ) + Summary3 + " " * Summary + oData["Kembalian"];
  list.add(LineText(type: LineText.TYPE_TEXT,content: SummaryText ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  print(SummaryText);

  Summary = MaxChar - MaxHargaJualSpaceBetwen - Summary4.length -  (oData["Diskon"]).toString().length;
  SummaryText = " " * (HargaJualInitialSpace ) + Summary4 + " " * Summary + oData["Diskon"];
  list.add(LineText(type: LineText.TYPE_TEXT,content: SummaryText ,weight: 0,align: LineText.ALIGN_LEFT,linefeed: 1));
  print(SummaryText);
  
  list.add(LineText(type: LineText.TYPE_TEXT,content: "-" * MaxChar ,weight: 0,align: LineText.ALIGN_RIGHT,linefeed: 1));
  list.add(LineText(linefeed: 1));
  list.add(LineText(type: LineText.TYPE_TEXT,content: oData["FooterNote"] ,weight: 0,align: LineText.ALIGN_CENTER,linefeed: 1));
  list.add(LineText(type: LineText.TYPE_TEXT,content: "PrintedOn: " + oData["PrintedDate"] ,weight: 0,align: LineText.ALIGN_CENTER,linefeed: 1));
  list.add(LineText(linefeed: 1));
  list.add(LineText(linefeed: 1));
  list.add(LineText(linefeed: 1));
  // await bluetoothPrint.printLabel(config, list);
  await bluetoothPrint.printReceipt(config, list);
}
