import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/Models/initialModel.dart';
import 'package:xposmenu/Pages/finishcheckout.dart';
import 'package:xposmenu/Shared/Lookup.dart';
import 'package:xposmenu/Shared/dialog.dart';

class CheckoutPage extends StatefulWidget {
  final Session sess;
  final List items;
  CheckoutPage(this.sess, this.items);
  @override
  _checkoutState createState() => _checkoutState();
}

class _checkoutState extends State<CheckoutPage> {
  final GlobalKey<State> _keyLoader = new GlobalKey<State>();

  List _variantMenu = [];
  List _addonMenu = [];

  int _idTipeOrder = -1;
  String _NamaTipeOrder = "";

  _GetVariantData(String KodeItem) async {
    for (var i = 0; i < this.widget.items.length; i++) {
      if (this.widget.items[i]["Qty"] > 0) {
        var tempVariant =await initialModel(this.widget.sess, {"KodeItem": KodeItem}).getVariantAddon();
        _variantMenu.add({this.widget.items[i]["KodeItem"]: tempVariant["variant"]});
        _addonMenu.add({this.widget.items[i]["KodeItem"]: tempVariant["addon"]});
      }
    }

    // return temp["data"];
  }

  double _calculateTotal() {
    double xTotal = 0;
    // Hitung Normal
    print(this.widget.items);
    for (var i = 0; i < this.widget.items.length; i++) {
      xTotal += (this.widget.items[i]["Qty"] * this.widget.items[i]["Price"]);

      // Variant
      for (var x = 0; x < this.widget.items[i]["Variant"].length; x++) {
        xTotal += this.widget.items[i]["Variant"][x]["ExtraPrice"];
      }
      // Addon
      for (var y = 0; y < this.widget.items[i]["Addon"].length; y++) {
        xTotal += this.widget.items[i]["Addon"][y]["HargaAddon"];
      }
    }
    print(xTotal);
    return xTotal;
  }

  bool SetEnableCommand() {
    bool xRet = true;

    for (var i = 0; i < this.widget.items.length; i++) {
      if (this.widget.items[i]["Variant"].length <
          this.widget.items[i]["Qty"]) {
        xRet = false;
        break;
      }
    }

    xRet = _idTipeOrder == -1 ? false : true;

    // print(xRet);

    return xRet;
  }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
  }

  @override
  void dispose() {
    // TODO: implement dispose
    for (var i = 0; i < this.widget.items.length; i++) {
      this.widget.items[i]["Variant"].clear();
      this.widget.items[i]["Addon"].clear();
    }
    // this.widget.items.clear();
    print("Item Cleared");
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    double totalCost = 0.0;

    return Scaffold(
        appBar: AppBar(
          title: Text('Checkout'),
        ),
        body: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'Order Summary',
                style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
              ),
              SizedBox(height: 20,),
              ListTile(
                title: GestureDetector(
                  child: _idTipeOrder == -1 ? 
                    Text("PILIH TIPE ORDER", style: TextStyle(fontSize: this.widget.sess.width! * 5, color: Colors.red, fontWeight: FontWeight.bold),) :
                    Text(_NamaTipeOrder, style: TextStyle(fontSize: this.widget.sess.width! * 5, color: Colors.red, fontWeight: FontWeight.bold),)
                ),
                onTap: ()async{
                  print(this.widget.sess.otipeOrder);
                  var result = await Navigator.push(context, MaterialPageRoute(builder: (context) => Lookup("Tipe Order", new initialModel(this.widget.sess, {}), idRetValue: "id",titleRetValue: "NamaJenisOrder",oOptionalList: this.widget.sess.otipeOrder,)),);
                  setState(() {
                    if(result != null) {
                      _idTipeOrder = result["ID"];
                      _NamaTipeOrder = result["Title"];
                    }
                      
                  });
                },
              ),
              SizedBox(height: 20),
              Expanded(
                child: ListView.builder(
                  itemCount: this.widget.items.length,
                  itemBuilder: (context, index) {
                    final item = this.widget.items[index];
                    final price = item['Price'] as double;
                    final qty = item['Qty'] as int;
                    final totalPrice = price * qty;
                    totalCost += totalPrice;

                    if (qty > 0) {
                      return Card(
                        margin: EdgeInsets.symmetric(vertical: 8.0),
                        child: Padding(
                          padding: const EdgeInsets.all(16.0),
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                'Menu : ${item['NamaItem']}',
                                style: TextStyle(fontWeight: FontWeight.bold),
                              ),
                              FutureBuilder(
                                  future: initialModel(this.widget.sess, {
                                    "KodeItem": item["KodeItem"],
                                    "RecordOwnerID":
                                        this.widget.sess.RecordOwnerID
                                  }).getVariantAddon(),
                                  builder: (context, snapshot) {
                                    if (snapshot.hasData) {
                                      print(
                                          this.widget.items[index]["Variant"]);
                                      if (snapshot.data!["variant"].length >
                                          0) {
                                        return item["Variant"].length <
                                                item["Qty"]
                                            ? GestureDetector(
                                                child: Card(
                                                  child: Padding(
                                                    padding: EdgeInsets.only(
                                                        top: 4,
                                                        left: 10,
                                                        right: 10,
                                                        bottom: 2),
                                                    child: Text(
                                                      "Tambah Varian Menu",
                                                      style: TextStyle(
                                                          color: Colors.amber),
                                                    ),
                                                  ),
                                                ),
                                                onTap: () async {
                                                  var result =
                                                      await Navigator.push(
                                                    context,
                                                    MaterialPageRoute(
                                                        builder: (context) =>
                                                            Lookup(
                                                              "Variant",
                                                              new initialModel(
                                                                  this
                                                                      .widget
                                                                      .sess,
                                                                  {}),
                                                              idRetValue:
                                                                  "VariantID",
                                                              titleRetValue:
                                                                  "NamaVariant",
                                                              oOptionalList:
                                                                  snapshot.data![
                                                                      "variant"],
                                                            )),
                                                  );
                                                  if (result != null) {
                                                    // var xData = snapshot.data!["variant"].where((item) => item['VariantID'] == result["ID"]).toList();
                                                    // print(this.widget.items[index]["Variant"]);
                                                    setState(() {
                                                      this
                                                          .widget
                                                          .items[index]
                                                              ["Variant"]
                                                          .add(snapshot
                                                              .data!["variant"]
                                                              .where((item) =>
                                                                  item[
                                                                      'VariantID'] ==
                                                                  result["ID"])
                                                              .toList()[0]);
                                                    });
                                                  }
                                                },
                                              )
                                            : Container();
                                      } else {
                                        return Container();
                                      }
                                    } else {
                                      return Container(
                                        child: Center(
                                          child: CircularProgressIndicator(),
                                        ),
                                      );
                                    }
                                  }),
                              Container(
                                  child: Column(
                                children: [
                                  for (int i = 0;
                                      i <
                                          this
                                              .widget
                                              .items[index]["Variant"]
                                              .length;
                                      i++)
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text("1 x " +
                                            this.widget.items[index]["Variant"]
                                                [i]["NamaVariant"]),
                                        Text(NumberFormat.currency(symbol: "Rp")
                                            .format(this.widget.items[index]
                                                ["Variant"][i]["ExtraPrice"]))
                                      ],
                                    )
                                ],
                              )),
                              SizedBox(height: 5),
                              Divider(),
                              Row(
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceBetween,
                                children: [
                                  Text(qty.toString() +
                                      " x " +
                                      NumberFormat('#,##0')
                                          .format(price)
                                          .toString()),
                                  Text(NumberFormat.currency(symbol: "Rp")
                                      .format(totalPrice))
                                ],
                              ),
                              SizedBox(height: 5),
                              Divider(),
                              FutureBuilder(
                                  future: initialModel(this.widget.sess, {
                                    "KodeItem": item["KodeItem"],
                                    "RecordOwnerID":
                                        this.widget.sess.RecordOwnerID
                                  }).getVariantAddon(),
                                  builder: (context, snapshot) {
                                    if (snapshot.hasData) {
                                      if (snapshot.data!["addon"].length > 0) {
                                        return GestureDetector(
                                          child: Card(
                                            child: Padding(
                                              padding: EdgeInsets.only(
                                                  top: 4,
                                                  left: 10,
                                                  right: 10,
                                                  bottom: 2),
                                              child: Text(
                                                "Tambah Addon",
                                                style: TextStyle(
                                                    color: Colors.brown),
                                              ),
                                            ),
                                          ),
                                          onTap: () async {
                                            var result = await Navigator.push(
                                              context,
                                              MaterialPageRoute(
                                                  builder: (context) => Lookup(
                                                        "Addon Menu",
                                                        new initialModel(
                                                            this.widget.sess,
                                                            {}),
                                                        idRetValue:
                                                            "AddonMenuID",
                                                        titleRetValue:
                                                            "NamaAddon",
                                                        oOptionalList: snapshot
                                                            .data!["addon"],
                                                        Subtitle: "HargaAddon",
                                                        subtitleType: 1,
                                                      )),
                                            );
                                            if (result != null) {
                                              // var xData = snapshot.data!["variant"].where((item) => item['VariantID'] == result["ID"]).toList();
                                              // print(this.widget.items[index]["Variant"]);
                                              setState(() {
                                                this
                                                    .widget
                                                    .items[index]["Addon"]
                                                    .add(snapshot.data!["addon"]
                                                        .where((item) =>
                                                            item[
                                                                'AddonMenuID'] ==
                                                            result["ID"])
                                                        .toList()[0]);
                                              });
                                            }
                                          },
                                        );
                                      } else {
                                        return Container();
                                      }
                                    } else {
                                      return Container(
                                        child: Center(
                                          child: CircularProgressIndicator(),
                                        ),
                                      );
                                    }
                                  }),
                              SizedBox(height: 5),
                              Container(
                                  child: Column(
                                children: [
                                  for (int i = 0;
                                      i <
                                          this
                                              .widget
                                              .items[index]["Addon"]
                                              .length;
                                      i++)
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text(
                                          "1 x " +
                                              this.widget.items[index]["Addon"]
                                                  [i]["NamaAddon"],
                                          style: TextStyle(color: Colors.red),
                                        ),
                                        Text(
                                          NumberFormat.currency(symbol: "Rp")
                                              .format(this.widget.items[index]
                                                  ["Addon"][i]["HargaAddon"]),
                                          style: TextStyle(color: Colors.red),
                                        )
                                      ],
                                    )
                                ],
                              )),
                              // if (item['Variant'] != null && item['Variant'].isNotEmpty)
                              //   Text('Variant: ${item['Variant'].join(', ')}'),
                              // if (item['Addon'] != null && item['Addon'].isNotEmpty)
                              //   Text('Add-ons: ${item['Addon'].join(', ')}'),
                            ],
                          ),
                        ),
                      );
                    }
                  },
                ),
              ),
              Divider(),
              Text(
                'Total: Rp. ${NumberFormat('#,##0').format(_calculateTotal())}',
                style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
        bottomNavigationBar: Padding(
          padding: const EdgeInsets.all(10.0),
          child: ElevatedButton(
              onPressed: !SetEnableCommand()
                  ? null
                  : () async{
                    showLoadingDialog(context, _keyLoader, info: "Save Data");

                      List oDetal = [];
                      List oVarian = [];
                      List oAddon = [];

                      for (var i = 0; i < this.widget.items.length; i++) {
                        Map xDetail() {
                          return {
                            'NoUrut': i.toString(),
                            'KodeItem': this.widget.items[i]["KodeItem"],
                            'Qty': this.widget.items[i]["Qty"].toString(),
                            'QtyKonversi': "1",
                            'Satuan': '',
                            'Harga': this.widget.items[i]["Price"].toString(),
                            'Discount': "0",
                            'HargaNet': (this.widget.items[i]["Qty"] *this.widget.items[i]["Price"]).toString(),
                            'BaseReff': 'POS',
                            'BaseLine': "-1",
                            'KodeGudang': this.widget.sess.oCompany![0]['GudangPoS'],
                            'LineStatus': "T",
                            'VatPercent': "0",
                            'HargaPokokPenjualan': "0",
                          };
                        }

                        // variant

                        for (var x = 0;x < this.widget.items[i]["Variant"].length;x++) {
                          Map xVariant() {
                            return {
                              'NoUrut': x,
                              'VariantGrupID': this.widget.items[i]["Variant"][x]["VariantGrupID"].toString(),
                              'VariantID': this.widget.items[i]["Variant"][x]["VariantID"].toString(),
                              'AddonMenuID': "-1",
                              'NamaGroupVariant': '',
                              'NamaVariant': this.widget.items[i]["Variant"][x]["NamaVariant"],
                              'ExtraQty': "1",
                              'ExtraPrice': this.widget.items[i]["Variant"][x]["ExtraPrice"].toString(),
                              'KodeItem': this.widget.items[i]["KodeItem"]
                            };
                          }

                          oVarian.add(xVariant());
                        }

                        for (var y = 0;y < this.widget.items[i]["Addon"].length;y++) {
                          Map xAddon() {
                            return {
                              'NoUrut': y.toString(),
                              'VariantGrupID': "-1",
                              'VariantID': "-1",
                              'AddonMenuID': this.widget.items[i]["Addon"][y]["AddonMenuID"].toString(),
                              'NamaGroupVariant': '',
                              'NamaVariant': this.widget.items[i]["Addon"][y]["NamaAddon"],
                              'ExtraQty': "1",
                              'ExtraPrice': this.widget.items[i]["Addon"][y]["HargaAddon"].toString(),
                              'KodeItem': this.widget.items[i]["KodeItem"]
                            };
                          }
                          oVarian.add(xAddon());
                        }

                        oDetal.add(xDetail());
                      }

                      Map oFullParam() {
                        return {
                          'NoTransaksi' : "",
                          'TglTransaksi' : DateFormat('yyyy-MM-dd').format(DateTime.now()),
                          'TglJatuhTempo' : DateFormat('yyyy-MM-dd').format(DateTime.now()),
                          'NoReff' : 'POS',
                          'KodeSales' : '',
                          'KodePelanggan' : "-",
                          'KodeTermin' : this.widget.sess.oCompany![0]['TerminBayarPoS'],
                          'Termin' : "0",
                          'TotalTransaksi' : _calculateTotal().toString(),
                          'Potongan' : "0",
                          'Pajak' : "0",
                          'Pembulatan' : "0",
                          'TotalPembelian' : _calculateTotal().toString(),
                          'TotalRetur' : "0",
                          'TotalPembayaran' : "0",
                          'Status' : "T",
                          'Keterangan' : '',
                          'MetodeBayar' : "",
                          'ReffPembayaran' : "",
                          'JenisOrder' : _idTipeOrder.toString(),
                          'KodeMeja' : this.widget.sess.KodeMeja,
                          'RecordOwnerID' : this.widget.sess.RecordOwnerID,
                          'DeviceID': this.widget.sess.DeviceID,
                          'Detail' : oDetal,
                          'Variant' : oVarian
                        };
                      }
                      // Navigator.push(context,MaterialPageRoute(builder: (context) => CheckoutPage(this.widget.sess,_oSelectedItem,)));

                      // print(oFullParam().toString());
                      var xSave = await initialModel(this.widget.sess, oFullParam()).SaveOrder().then((value) async{
                        if (value["success"]) {
                          Navigator.of(context, rootNavigator: true).pop();
                          Navigator.pushReplacement(context,MaterialPageRoute(builder: (context) => FinishCheckout(this.widget.sess,_calculateTotal(),)));
                        } else {
                          Navigator.of(context, rootNavigator: true).pop();
                          await messageBox(context: context,title: "Infomasi",message: value["message"]);
                        }
                      });
                    },
              child: Text("Pesan Sekarang")),
        ));
  }
}
