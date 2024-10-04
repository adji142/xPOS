import 'package:flutter/material.dart';
import 'dart:async';

import 'package:intl/intl.dart';

class Lookup extends StatefulWidget {

  final String ? title;
  final dynamic datamodel;
  final String ? idRetValue;
  final String ? titleRetValue;
  final List ? oOptionalList;
  final String ? Subtitle;
  final int ? subtitleType; // 1 : Number Decimal

  Lookup(this.title, this.datamodel, {this.idRetValue = "ID", this.titleRetValue="Title", this.oOptionalList, this.Subtitle = "", this.subtitleType = -1});
  
  @override
  _LookupState createState() => _LookupState();
}

class _LookupState extends State<Lookup> {

  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = Icon(Icons.search, size: 32.0,);
  TextEditingController _searchText = TextEditingController();

  List ? oData = [];
  List ? filterdData = [];
  
  @override
  void initState() {
    super.initState();
    // _selectDate(context);
    if (this.widget.oOptionalList!.length == 0) {
      _fetchData(); 
    }
    _searchText.addListener(() {
      filterSearchResults(_searchText.text);
    });
  }

  Future<List>_getData() async{
    var temp = await this.widget.datamodel.getLookup(context,search: this._searchText.text, short: this._short);
    // _droping = temp.toList();
    return temp;
  }

  _fetchData() async{
    var temp = await _getData();
    oData = temp;
    filterdData = temp;
    setState(() => {});
  }

  void filterSearchResults(String query) {
    List results = [];
    if (query.isNotEmpty) {
      results = oData!.where((item) => (item[this.widget.idRetValue]+item[this.widget.titleRetValue]).toLowerCase().contains(query.toLowerCase())).toList();
    } else {
      results = oData!;
    }
    setState(() {
      filterdData = results;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
            title: _searchWidget(),
            actions: <Widget>[
              IconButton(
                icon: _appIcon,
                onPressed: () {
                  _searchMode = _searchMode ? false: true;
                  _searchText.text = "";
                  setState(() => _appIcon = _searchMode ? Icon(Icons.search) : Icon(Icons.close));                  
                },
              ),

              IconButton(
                icon: Icon(Icons.import_export, size: 32,),
                onPressed: (){
                  _short = _short == 0 ? 1 : 0;
                  setState((){});
                },
              )
            ],
      ),
      body: this.widget.oOptionalList!.length == 0 ? _itemData(filterdData!): _itemData(this.widget.oOptionalList!),
    );
  }
  
  Widget _searchWidget() {
    if(_searchMode) {
      return Text(this.widget.title!);
    }else {
      return (
        Container(
          color: Theme.of(context).primaryColorLight,
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: _searchText,
              autofocus: true,
              decoration: InputDecoration.collapsed(hintText: "Cari Data"),
              textInputAction: TextInputAction.search,
              onChanged: (value) => setState((){})
            ),
          )
        )
      );
    }
  }

  Widget _itemData(List list) {
    return list.length == 0 ? Container(
      child: Center(
        child: CircularProgressIndicator(),
      ),
    ) : RefreshIndicator(
          onRefresh: ()=> _refreshData(),
          child: ListView.builder(
          itemCount: list.length,
          itemBuilder: (context, index) {
            return Card(
                      child: ListTile(
                        //leading: Icon(Icons.check_circle_outline, color: Theme.of(context).primaryColor,),
                        title: Text(list[index][this.widget.titleRetValue].toString(),  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                          ),
                        ),
                        subtitle: this.widget.Subtitle == "" ? Text("") : Text(this.widget.subtitleType == -1 ?
                          list[index][this.widget.Subtitle]
                          : this.widget.subtitleType == 1 ?
                            NumberFormat().format(list[index][this.widget.Subtitle])
                            : list[index][this.widget.Subtitle]
                        ),
                        onTap: (){
                          Navigator.pop(context, {
                            "ID" : list[index][this.widget.idRetValue],
                            "Title" : list[index][this.widget.titleRetValue],
                            "Subtitle" : list[index][this.widget.Subtitle],
                          });
                        },
                      ),
                    );
          },
      ),
    );
  }

  Future _refreshData() async{
      setState((){});

      Completer<Null> completer = Completer<Null>();
      Future.delayed(Duration(seconds: 1)).then( (_) {
        completer.complete();
      });
      return completer.future;
  }

}
