import 'dart:convert';
import 'dart:typed_data';

import 'package:flutter/material.dart';
import 'package:flutter/rendering.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/Models/initialModel.dart';

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
    setState(() => {});
  }

  Future<Map> _getData() async {
    Map oParam() {
      return {
        "RecordOwnerID": this.widget.sess.RecordOwnerID,
        "KodeMeja" : this.widget.sess.KodeMeja,
        "IPAddress" : this.widget.sess.IPAddress,
        "DeviceID" : this.widget.sess.DeviceID
      };
    }

    var temp = await initialModel(this.widget.sess,oParam()).initData();
    // _droping = temp.toList();
    return temp;
  }
  

  @override
  void initState() {
    super.initState();
    _fetchData();
  }

  // Generate Data

  @override
  Widget build(BuildContext context) {
    int crossAxisCount = 0 ;
    if (this.widget.sess.width! * 100 > 1200) {
      crossAxisCount = 6; // Large screens (e.g., tablets, desktops)
    } else if (this.widget.sess.width! * 100 > 800) {
      crossAxisCount = 4; // Medium screens
    } else {
      crossAxisCount = 2; // Small screens (e.g., phones)
    }


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
                bottom: this.widget.sess.width! * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess.hight! * (this.widget.sess.orientation == Orientation.landscape ? 50 : 30),
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
                      }
                    ),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: List.generate(base64Images.length, (index) {
                        return GestureDetector(
                          onTap: (){
                            _controller.jumpToPage(index);
                          },
                          child: Container(
                            margin: const EdgeInsets.all(5.0),
                            width: _curentPage == index ? 12.0 : 8.0,
                            height: _curentPage == index ? 12.0 : 8.0,
                            decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              color: _curentPage == index ? Colors.blue : Colors.grey,
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
                top: this.widget.sess.width! * (this.widget.sess.orientation == Orientation.landscape ? 0 : this.widget.sess.width! *1),
                left: this.widget.sess.width! * 2,
                right: this.widget.sess.width! * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess.hight! * 5,
                // color: Colors.black,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: _oDataJenisItem.length,
                  itemBuilder: (context, index){
                    return GestureDetector(
                      child: Padding(
                        padding: EdgeInsets.only(right: this.widget.sess.width! * 2),
                        child: Text(
                          _oDataJenisItem[index]["NamaJenis"],
                          style: TextStyle(
                            fontWeight: _SelectedJenisItem == _oDataJenisItem[index]["KodeJenis"] ? FontWeight.bold : FontWeight.normal,
                            fontSize: this.widget.sess.orientation == Orientation.portrait ? 
                              _SelectedJenisItem == _oDataJenisItem[index]["KodeJenis"] ? this.widget.sess.width! *4 : this.widget.sess.width! *3.5 :
                              _SelectedJenisItem == _oDataJenisItem[index]["KodeJenis"] ? this.widget.sess.width! *2 : this.widget.sess.width! *1.5,
                          ),
                        ),
                      ),
                      onTap: (){
                        setState(() {
                          _SelectedJenisItem = _oDataJenisItem[index]["KodeJenis"];
                        });
                      },
                    );
                  }
                )
              ),
            ),
            Padding(
              padding: EdgeInsets.only(
                top: this.widget.sess.width! * (this.widget.sess.orientation == Orientation.landscape ? 0 : this.widget.sess.width! *1),
                left: this.widget.sess.width! * 2,
                right: this.widget.sess.width! * 2
              ),
              child: Container(
                width: double.infinity,
                height: this.widget.sess.hight! * 100,
                // color: Colors.amber,
                child: GridView.builder(
                  gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                    crossAxisCount: crossAxisCount,
                    crossAxisSpacing: 10.0,
                    mainAxisSpacing: 10.0,
                    childAspectRatio: 1.0,
                  ), 
                  itemCount: 20,
                  itemBuilder: (context, index){
                    return Container(
                      color: Colors.blueAccent,
                      alignment: Alignment.center,
                      child: Text(
                        'Item $index',
                        style: TextStyle(color: Colors.white, fontSize: 16),
                      ),
                    );
                  }
                ),
              ),
            )
          ],
        )
      ),
    );
  }
}
