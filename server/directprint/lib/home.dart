import 'dart:async';

import 'package:bluetooth_print/bluetooth_print.dart';
import 'package:bluetooth_print/bluetooth_print_model.dart';
import 'package:directprint/models/printer.dart';
import 'package:directprint/shared/Session.dart';
import 'package:directprint/shared/dialog.dart';
import 'package:directprint/shared/printerlayout.dart';
import 'package:directprint/shared/retailPoSLayout.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';

class DashboardPage extends StatefulWidget {
  final Session? sess;
  const DashboardPage(this.sess, {super.key});

  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  BluetoothPrint bluetoothPrint = BluetoothPrint.instance;

  String selectedOption = "Bluetooth";
  final GlobalKey<State> _keyLoader = GlobalKey<State>();

  Future<void> initBluetooth() async {
    bluetoothPrint.startScan(timeout: Duration(seconds: 4));

    bool isConnected = await bluetoothPrint.isConnected ?? false;

    bluetoothPrint.state.listen((state) {
      print('******************* cur device status: $state');

      switch (state) {
        case BluetoothPrint.CONNECTED:
          setState(() {
            this.widget.sess!.printerConnected = true;
            // tips = 'connect success';
          });
          break;
        case BluetoothPrint.DISCONNECTED:
          setState(() {
            this.widget.sess!.printerConnected = false;
            // tips = 'disconnect success';
          });
          break;
        case 12:
          // bluetoothPrint.disconnect();
          setState(() {
            this.widget.sess!.printerConnected = false;
            // tips = 'disconnect success';
          });
          break;
        default:
          setState(() {
            this.widget.sess!.printerConnected = false;
            // tips = 'disconnect success';
          });
          break;
      }
    });

    if (!mounted) return;

    if (isConnected) {
      setState(() {
        this.widget.sess!.printerConnected = true;
      });
    }
  }

  void CurrentDevice(DeviceAddress, PrintType, ReceiptData) async {
    if (await bluetoothPrint.isAvailable) {
      // print(bluetoothPrint.scanResults);
      bluetoothPrint.scanResults.listen((event) async {
        for (BluetoothDevice result in event) {
          print(result.address.toString() + " > " + DeviceAddress);

          if(result.address == DeviceAddress){
            
            switch (PrintType) {
              case "Connect" : 
                await bluetoothPrint.connect(result);
              case "PrintTest":
                if(!this.widget.sess!.printerConnected){
                  await bluetoothPrint.connect(result);
                  await Future.delayed(Duration(seconds: 5));
                  testprintReciept(bluetoothPrint, ReceiptData);
                }
                else{
                  testprintReciept(bluetoothPrint, ReceiptData);
                }
                break;
              case "Retail" :
                if(!this.widget.sess!.printerConnected){
                  await bluetoothPrint.connect(result);
                  await Future.delayed(Duration(seconds: 5));
                  retailPoSLayout(bluetoothPrint, ReceiptData);
                }
                else{
                  retailPoSLayout(bluetoothPrint, ReceiptData);
                }
              default:
            }

            // if(!this.widget.sess!.printerConnected){
            //   await bluetoothPrint.connect(result);
            //   if(PrintType == "PrintTest") {
            //     testprintReciept(bluetoothPrint, ReceiptData);
            //   }
            // }
            // else{
            //   if(PrintType == "PrintTest") {
            //     testprintReciept(bluetoothPrint, ReceiptData);
            //   }
            // }
            setState(() {
              this.widget.sess!.printerDevice= result;
              this.widget.sess!.printerConnected= true;
            });
            break;
          }
        }
      });
    }
  }

  @override
  void initState() {
    super.initState();
    print("1. tatus Printer : " + bluetoothPrint.isAvailable.then((value) => value).toString());
    WidgetsBinding.instance.addPostFrameCallback((_) => initBluetooth());
    var message = FirebaseMessaging.instance;

    message.getToken().then((value) {
      // widget.sess!.Token = value.toString();
      print("Token :" + value.toString());
    });
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      print("I have feedback =>");
      var DeviceAddress = message.data["DeviceAddress"];
      print(message.data["DeviceAddress"]);
      if(DeviceAddress.toString() != ""){
        CurrentDevice(DeviceAddress,message.data["RecieptType"], message.data["RecieptData"]);
        // printReciept(message.data["RecieptData"]);
        print("2. Status Printer : " + bluetoothPrint.isAvailable.then((value) => value).toString());
      }
    });
  }

  @override
  void dispose() {
    bluetoothPrint.disconnect();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    // print(this.widget.sess!.Token);
    Map oParam() {
      return {"RecordOwnerID": this.widget.sess!.RecordOwnerID};
    }
    // print(oParam());
    return Scaffold(
        appBar: AppBar(
          title: Text("Daftar Printer"),
        ),
        body: Padding(
          padding: EdgeInsets.all(this.widget.sess!.width * 2),
          child: FutureBuilder(
              future: PrinterData(this.widget.sess, Parameter: oParam())
                  .printerlist(),
              builder: (context, AsyncSnapshot<Map> snapshot) {
                if (snapshot.hasData) {
                  // print(snapshot.data);
                  return RefreshIndicator(
                      child: ListView.builder(
                          itemCount: snapshot.data!["data"] == null? 0: snapshot.data!["data"]!.length,
                          itemBuilder: (context, index) {
                            // CurrentDevice(snapshot.data!["data"][index]["DeviceAddress"]);
                            return Card(
                              child: ListTile(
                                leading: Icon(Icons.print_rounded),
                                title: Text(
                                    snapshot.data!["data"][index]
                                        ["NamaPrinter"],
                                    style: TextStyle(
                                        color:
                                            Theme.of(context).primaryColorDark,
                                        fontWeight: FontWeight.bold)),
                                subtitle: Text(
                                  snapshot.data!["data"][index]
                                          ["DeviceAddress"] +
                                      " (" +
                                      snapshot.data!["data"][index]
                                          ["PrinterInterface"] +
                                      ") ",
                                ),
                                trailing: Icon(Icons.arrow_forward),
                                onTap: () {
                                  _showDetail(context,snapshot.data!["data"][index]["DeviceAddress"] );
                                },
                              ),
                            );
                          }),
                      onRefresh: _refreshData);
                } else {
                  return Container(
                    child: Center(
                      child: Text("No Data"),
                    ),
                  );
                }
              }),
        ),
        floatingActionButton: FloatingActionButton(
            child: Icon(Icons.add),
            onPressed: () async {
              _showRadioDialog(context);
            }));
  }

  void _showDetail(BuildContext context, String PrinterAddress) {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            title: Text(this.widget.sess!.PrinterName),
            content: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                ElevatedButton(
                  style: ButtonStyle(
                      shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                          RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18.0),
                      )),
                      backgroundColor: MaterialStateProperty.all(Colors.green)),
                  onPressed: this.widget.sess!.printerConnected == false
                      ? () async {
                          // await bluetoothPrint.connect(this.widget.sess!.printerDevice!);
                          CurrentDevice(PrinterAddress, "Connect", "");
                          Navigator.pop(context);
                        }
                      : null,
                  child: Text(
                    "Connect",
                    style: TextStyle(color: Colors.white),
                  ),
                ),
                ElevatedButton(
                  style: ButtonStyle(
                      shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                          RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18.0),
                      )),
                      backgroundColor: MaterialStateProperty.all(Colors.red)),
                  onPressed: this.widget.sess!.printerConnected
                      ? () async {
                          this.widget.sess!.printerConnected = false;
                          await bluetoothPrint.disconnect().then((value) {
                            setState(() {});
                          });
                          Navigator.pop(context);
                        }
                      : null,
                  child: Text(
                    "Disconnect",
                    style: TextStyle(color: Colors.white),
                  ),
                ),
                ElevatedButton(
                  style: ButtonStyle(
                      shape: MaterialStateProperty.all<RoundedRectangleBorder>(
                          RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18.0),
                      )),
                      backgroundColor: MaterialStateProperty.all(Colors.green)),
                  onPressed: () async {},
                  child: Text(
                    "Test Print",
                    style: TextStyle(color: Colors.white),
                  ),
                )
              ],
            ),
          );
        });
  }

  void _showRadioDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return StatefulBuilder(
          builder: (BuildContext context, StateSetter setState) {
            return AlertDialog(
                title: Text('Hubungkan Printer'),
                content: Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  mainAxisSize: MainAxisSize.min,
                  children: <Widget>[
                    Row(
                      children: [
                        Radio<String>(
                          value: 'Bluetooth',
                          groupValue: selectedOption,
                          onChanged: (String? value) {
                            setState(() {
                              selectedOption = value!;
                            });
                          },
                        ),
                        Text("Bluetooth"),
                        Radio<String>(
                          value: 'USB',
                          groupValue: selectedOption,
                          onChanged: (String? value) {
                            setState(() {
                              selectedOption = value!;
                            });
                          },
                        ),
                        Text("USB")
                      ],
                    ),
                    selectedOption == "Bluetooth"
                        ? StreamBuilder<List<BluetoothDevice>>(
                            stream: bluetoothPrint.scanResults,
                            initialData: [],
                            builder: (c, snapshot) => Column(
                                  children: snapshot.data!
                                      .map((d) => ListTile(
                                            title: Text(d.name ?? ''),
                                            subtitle: Text(d.address ?? ''),
                                            onTap: () async {
                                              setState(() {
                                                this
                                                    .widget
                                                    .sess!
                                                    .printerDevice = d;
                                                this.widget.sess!.PrinterName =
                                                    d.name!;
                                                this
                                                        .widget
                                                        .sess!
                                                        .PrinterAddress =
                                                    d.address!;
                                              });
                                            },
                                            trailing: this
                                                            .widget
                                                            .sess!
                                                            .printerDevice !=
                                                        null &&
                                                    this
                                                            .widget
                                                            .sess!
                                                            .printerDevice!
                                                            .address ==
                                                        d.address
                                                ? Icon(
                                                    Icons.check,
                                                    color: Colors.green,
                                                  )
                                                : null,
                                          ))
                                      .toList(),
                                ))
                        : Container()
                  ],
                ),
                actions: [
                  ElevatedButton(
                    style: ButtonStyle(
                        shape:
                            MaterialStateProperty.all<RoundedRectangleBorder>(
                                RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(18.0),
                        )),
                        backgroundColor: MaterialStateProperty.all(
                            Theme.of(context).primaryColor)),
                    onPressed: () async {
                      showLoadingDialog(context, _keyLoader,
                          info: "Begin Login");
                      var message = FirebaseMessaging.instance;
                      await message.getToken().then((value) async {
                        Map oTemp = {
                          "NamaPrinter": this.widget.sess!.PrinterName,
                          "PrinterInterface": selectedOption,
                          "DeviceName": this.widget.sess!.PrinterName,
                          "DeviceAddress": this.widget.sess!.PrinterAddress,
                          "PrinterToken": value,
                          "RecordOwnerID": this.widget.sess!.RecordOwnerID
                        };
                        // print(oTemp);

                        if (this.widget.sess!.printerDevice != null &&
                            this.widget.sess!.printerDevice!.address != null) {
                          await bluetoothPrint
                              .connect(this.widget.sess!.printerDevice!);

                          await PrinterData(this.widget.sess, Parameter: oTemp)
                              .printerstore()
                              .then((retval) {
                            if (retval["success"] == true) {
                              // Navigator.pop(context);
                              messageBox(
                                  context: context,
                                  title: "Informasi",
                                  message: "Data Berhasil Tersimpan");
                              Navigator.of(context, rootNavigator: true).pop();
                              Navigator.pop(context);
                              Navigator.pop(context);
                            } else {
                              Navigator.of(context, rootNavigator: true).pop();
                              messageBox(
                                  context: context,
                                  title: "Informasi",
                                  message: retval["message"]);
                            }
                          });
                        } else {
                          Navigator.of(context, rootNavigator: true).pop();
                          messageBox(
                              context: context,
                              title: "Informasi",
                              message: "Device Currently connected");
                        }
                      });
                      setState(() {});
                      // Navigator.pop(context);
                    },
                    child: Text(
                      "Hubungkan dan Simpan",
                      style: TextStyle(color: Colors.white),
                    ),
                  )
                ]);
          },
        );
      },
    ).then((value) {
      if (value != null) {
        setState(() {
          selectedOption = value;
        });
      }
    });
  }

  Future _refreshData() async {
    setState(() {});
    Completer<Null> completer = Completer<Null>();
    Future.delayed(Duration(seconds: 1)).then((_) {
      completer.complete();
    });
    return completer.future;
  }
}
