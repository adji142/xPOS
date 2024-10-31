import 'dart:convert';
import 'dart:typed_data';

import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter/rendering.dart';
import 'package:intl/intl.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/Models/initialModel.dart';
import 'package:xposmenu/Pages/checkout.dart';
import 'package:xposmenu/Pages/finishcheckout.dart';

class ListMenu extends StatefulWidget {
  final Session sess;
  ListMenu(this.sess);
  @override
  _ListMenu createState() => _ListMenu();
}

class _ListMenu extends State<ListMenu> {
  final PageController _controller = PageController();
  int _curentPage = 0;
  Map _oData = {};
  String _SelectedJenisItem = "";
  List _oDataJenisItem = [];

  Map _oMenu = {};
  List _oVariant = [];
  List _oAddon = [];

  int totalItems = 0;
  double totalCost = 0.0;

  List _oSelectedItem = [];

  final List<String> base64Images = [];

  Uint8List _base64ToImage(String base64String) {
    return Base64Decoder().convert(base64String);
  }

  _fetchData() async {
    var temp = await _getData();
    _oData = temp;

    for (var i = 0; i < _oData["company"].length; i++) {
      // data:image/png;base64,
      base64Images.add(_oData["company"][i]["Banner1"].toString().replaceAll("data:image/png;base64,", ""));
      base64Images.add(_oData["company"][i]["Banner2"].toString().replaceAll("data:image/png;base64,", ""));
      base64Images.add(_oData["company"][i]["Banner3"].toString().replaceAll("data:image/png;base64,", ""));
    }
    _oDataJenisItem = _oData["kelompokmenu"];

    Map<String, dynamic> newItem = {
      "KodeJenis": "",
      "NamaJenis": "ALL",
      "RecordOwnerID": "CL0002",
      "created_at": "2024-10-03T10:00:00.000000Z",
      "updated_at": "2024-10-03T10:00:00.000000Z"
    };
    _oDataJenisItem.insert(0, newItem);
    this.widget.sess.oCompany = _oData["company"];
    this.widget.sess.otipeOrder = _oData["tipeorder"];
    setState(() => {});
  }

  Future<Map> _getData() async {
    Map oParam() {
      return {
        "RecordOwnerID": this.widget.sess.RecordOwnerID,
        "KodeMeja": this.widget.sess.KodeMeja,
        "IPAddress": this.widget.sess.IPAddress,
        "DeviceID": this.widget.sess.DeviceID
      };
    }

    var temp = await initialModel(this.widget.sess, oParam()).initData();
    // _droping = temp.toList();
    return temp;
  }

  getMenuInfo(String KodeItem, int BaseType) async {
    /*
      1. Menu
      2. Variant
      3. Addon
    */

    switch (BaseType) {
      case 1:
        Map oParam() {
          return {"KodeKelompok": _SelectedJenisItem};
        }
        _oMenu = await initialModel(this.widget.sess, oParam()).getMenu();
        break;
      case 2:
        Map oParam() {
          return {"KodeItem": KodeItem};
        }
        var temp =
            await initialModel(this.widget.sess, oParam()).getVariantAddon();
        _oVariant = temp["variant"];
      default:
        return {};
    }
    setState(() => {});
  }

  void _addItemToCart(String KodeItem,String NamaItem, int Qty, double Price, List oVariant, List oAddon) async{
    int index = _oSelectedItem.indexWhere((item)=> item["KodeItem"] == KodeItem);
    setState(() {
      if (index != -1) {
        _oSelectedItem[index]["Qty"] += Qty;
      }
      else{
        _oSelectedItem.add({'KodeItem':KodeItem,"NamaItem" : NamaItem, 'Qty':Qty,'Price':Price, 'ExtraPrice' : 0,'Variant':oVariant,'Addon':oAddon});
      }
    });
  }

  @override
  void initState() {
    super.initState();
    _fetchData();
    // getMenuInfo("",1);
  }

  // Generate Data

  @override
  Widget build(BuildContext context) {
    int crossAxisCount = 0;
    if (this.widget.sess.width! * 100 > 1200) {
      crossAxisCount = 6; // Large screens (e.g., tablets, desktops)
    } else if (this.widget.sess.width! * 100 > 800) {
      crossAxisCount = 4; // Medium screens
    } else {
      crossAxisCount = 2; // Small screens (e.g., phones)
    }

    Map oParam() {
      return {"KodeKelompok": _SelectedJenisItem};
    }

    Map<String, int> result = {};

    for (var item in _oSelectedItem) {
      String KodeItem = item['KodeItem'];
      int Price = item['Price'];
      int Qty = item['Qty'];

      if (result.containsKey(KodeItem)) {
        result[KodeItem] = result[KodeItem]! + (Price * Qty);
      } else {
        result[KodeItem] = Price * Qty;
      }
    }

    // print(result);
    int _sumItem = 0;
    result.forEach((key, value) {
      _sumItem += value;
    });

    return Scaffold(
      appBar: AppBar(
        title: Text("Test Web Apps " + this.widget.sess.PartnerName.toString()),
      ),
      body: SingleChildScrollView(
          child: Column(
        children: [
          Padding(
            padding: EdgeInsets.only(
                left: this.widget.sess.width! * 2,
                right: this.widget.sess.width! * 2,
                bottom: this.widget.sess.width! * 2),
            child: Container(
              width: double.infinity,
              height: this.widget.sess.hight! *
                  (this.widget.sess.orientation == Orientation.landscape
                      ? 50
                      : 30),
              // color: Colors.red,
              child: Stack(
                children: [
                  PageView.builder(
                      controller: _controller,
                      onPageChanged: (int index) {
                        setState(() {
                          _curentPage = index;
                        });
                      },
                      itemCount: base64Images.length,
                      itemBuilder: (context, index) {
                        return Image.memory(
                          _base64ToImage(base64Images[index]),
                          fit: BoxFit.cover,
                        );
                      }),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: List.generate(base64Images.length, (index) {
                      return GestureDetector(
                        onTap: () {
                          _controller.jumpToPage(index);
                        },
                        child: Container(
                          margin: const EdgeInsets.all(5.0),
                          width: _curentPage == index ? 12.0 : 8.0,
                          height: _curentPage == index ? 12.0 : 8.0,
                          decoration: BoxDecoration(
                            shape: BoxShape.circle,
                            color: _curentPage == index
                                ? Colors.blue
                                : Colors.grey,
                          ),
                        ),
                      );
                    }),
                  )
                ],
              ),
            ),
          ),
          Divider(),
          Padding(
            padding: EdgeInsets.only(
                top: this.widget.sess.width! *
                    (this.widget.sess.orientation == Orientation.landscape
                        ? 0
                        : this.widget.sess.width! * 1),
                left: this.widget.sess.width! * 2,
                right: this.widget.sess.width! * 2),
            child: Container(
                width: double.infinity,
                height: this.widget.sess.hight! * 5,
                // color: Colors.black,
                child: ListView.builder(
                    scrollDirection: Axis.horizontal,
                    itemCount: _oDataJenisItem.length,
                    itemBuilder: (context, index) {
                      return GestureDetector(
                        child: Padding(
                          padding: EdgeInsets.only(
                              right: this.widget.sess.width! * 2),
                          child: Text(
                            _oDataJenisItem[index]["NamaJenis"],
                            style: TextStyle(
                              fontWeight: _SelectedJenisItem ==
                                      _oDataJenisItem[index]["KodeJenis"]
                                  ? FontWeight.bold
                                  : FontWeight.normal,
                              fontSize: this.widget.sess.orientation ==
                                      Orientation.portrait
                                  ? _SelectedJenisItem ==
                                          _oDataJenisItem[index]["KodeJenis"]
                                      ? this.widget.sess.width! * 4
                                      : this.widget.sess.width! * 3.5
                                  : _SelectedJenisItem ==
                                          _oDataJenisItem[index]["KodeJenis"]
                                      ? this.widget.sess.width! * 2
                                      : this.widget.sess.width! * 1.5,
                            ),
                          ),
                        ),
                        onTap: () {
                          setState(() {
                            _SelectedJenisItem =
                                _oDataJenisItem[index]["KodeJenis"];
                          });
                        },
                      );
                    })),
          ),
          Container(
              width: double.infinity,
              height: this.widget.sess.hight! * 100,
              child: LayoutBuilder(builder: (context, constraints) {
                int crossAxisCount = constraints.maxWidth < 600 ? 2 : 6;
                double childAspectRatio =
                    constraints.maxWidth < 600 ? 0.75 : 0.8;

                // print(_oMenu);
                return Padding(
                    padding: const EdgeInsets.all(10.0),
                    child: FutureBuilder(
                        future:
                            initialModel(this.widget.sess, oParam()).getMenu(),
                        builder: (context, snapshot) {
                          if (snapshot.hasData) {
                            // print(snapshot.data);
                            return GridView.builder(
                              gridDelegate:
                                  SliverGridDelegateWithFixedCrossAxisCount(
                                crossAxisCount: crossAxisCount,
                                crossAxisSpacing: 10.0,
                                mainAxisSpacing: 10.0,
                                childAspectRatio: childAspectRatio,
                              ),
                              itemCount: snapshot.data!["data"]
                                  .length, // Number of items in the menu
                              itemBuilder: (context, index) {
                                // print(_oMenu["data"][index]);
                                return MenuItemCard(
                                    snapshot.data!["data"][index]);
                              },
                            );
                          } else {
                            return Center(child: CircularProgressIndicator());
                          }
                        }));
              }))
        ],
      )),
      bottomNavigationBar: Padding(
        padding: const EdgeInsets.all(10.0),
        child: ElevatedButton(
          onPressed: _sumItem > 0? () async{
            print(_oSelectedItem);
            await Navigator.push(context,MaterialPageRoute(builder: (context) => CheckoutPage(this.widget.sess,_oSelectedItem,))).then((value){
              if (value) {
                setState(() {
                  print("Done Transaction");
                });
              }
            });
          }
          : null, // Disable the button if no items added
          style: ElevatedButton.styleFrom(
            padding: EdgeInsets.symmetric(vertical: 15),
            primary: _sumItem > 0 ? Colors.green : Colors.grey,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(10),
            ),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Padding(
                padding: EdgeInsets.only(left: 15),
                child: Text(
                  _oSelectedItem.length.toString() + 'Items',
                  style: TextStyle(fontSize: 18, color: Colors.white),
                ),
              ),
              Padding(
                padding: EdgeInsets.only(right: 15),
                child: Text(
                  'Checkout - ${NumberFormat.currency(symbol: "Rp").format(_sumItem)}',
                  style: TextStyle(fontSize: 18, color: Colors.white),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }

  Widget MenuItemCard(ItemData) {
    // print(ItemData);
    final formatter = NumberFormat('#,##0');
    int _sumItem = 0;
    _sumItem = _oSelectedItem.where((item)=>item["KodeItem"] == ItemData["KodeItem"]).map((item)=> item["Qty"] as int).fold(0, (previousValue, element) => previousValue + element);
    return Card(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(15.0),
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          ClipRRect(
            borderRadius: BorderRadius.circular(15),
            child: Image.memory(
              Base64Decoder().convert(ItemData["Gambar"].replaceAll(
                  "data:image/jpeg;base64,",
                  "")), // Replace with actual image URL
              height: 120,
              width: double.infinity,
              fit: BoxFit.cover,
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(left: 8.0, right: 8.0, top: 4.0),
            child: Text(
              softWrap: true,
              ItemData["NamaItem"].toString(),
              style: TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(left: 8.0, right: 8.0, bottom: 3.0),
            child: Text(
              "Rp. " + formatter.format(ItemData["HargaJual"]),
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(bottom: 3.0),
            child: _sumItem > 0 ? Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Padding(
                  padding: EdgeInsets.all(2),
                    child: ClipOval(
                    child: Material(
                      color: Colors.blue,
                      child:  InkWell(
                        splashColor: Colors.white,
                        child: Icon(Icons.remove),
                        onTap: (){
                          _addItemToCart(ItemData["KodeItem"],ItemData["NamaItem"],-1,ItemData["HargaJual"],[],[]);
                        },
                      ),
                    ),
                  ),
                ),
                Padding(
                  padding: EdgeInsets.all(2),
                  child: Text(_sumItem.toString()),
                ),
                Padding(
                  padding: EdgeInsets.all(2),
                  child: ClipOval(
                    child: Material(
                      color: Colors.blue,
                      child:  InkWell(
                        splashColor: Colors.white,
                        child: Icon(Icons.add),
                        onTap: (){
                          _addItemToCart(ItemData["KodeItem"],ItemData["NamaItem"],1,ItemData["HargaJual"],[],[]);
                        },
                      ),
                    ),
                  ),
                ),
              ],
            ):ElevatedButton(
              onPressed: () {
                _addItemToCart(ItemData["KodeItem"],ItemData["NamaItem"],1,ItemData["HargaJual"],[],[]);
              },
              child: Text("Add to Cart"),
            ),
          ),
        ],
      ),
    );
  }

  void _showBottomPopup(String KodeItem, String NamaItem, List Variant, List Addon) {
    int itemQty = _oSelectedItem .firstWhere((item) => item["KodeItem"] == KodeItem)["Qty"];
    String selectedOption = 'Option 1';
    
    showModalBottomSheet(
      context: context,
      builder: (context) {
        return StatefulBuilder(builder: (context, setState) {
          return Container(
            padding: EdgeInsets.all(16.0),
            height: 200,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  'Item: $NamaItem',
                  style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                ),
                // Variant
                Wrap(
                  spacing: 10,
                  children: [
                    RadioListTile<String>(
                      title: Text('Option 1'),
                      value: 'Option 1',
                      groupValue: selectedOption,
                      onChanged: (value) {
                        setState(() {
                          selectedOption = value!;
                        });
                      },
                    ),
                    RadioListTile<String>(
                      title: Text('Option 2'),
                      value: 'Option 2',
                      groupValue: selectedOption,
                      onChanged: (value) {
                        setState(() {
                          selectedOption = value!;
                        });
                      },
                    ),
                    RadioListTile<String>(
                      title: Text('Option 3'),
                      value: 'Option 3',
                      groupValue: selectedOption,
                      onChanged: (value) {
                        setState(() {
                          selectedOption = value!;
                        });
                      },
                    ),
                  ],
                )
              ],
            ),
          );
        });
      }
    );
  }
}
