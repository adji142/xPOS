import 'package:flutter/material.dart';
import 'dart:async';

class Lookup extends StatefulWidget {

  final String title;
  final dynamic datamodel;
  final Map ? parameter;

  const Lookup({super.key, required this.title, this.datamodel, this.parameter});
  
  @override
  _LookupState createState() => _LookupState();
}

class _LookupState extends State<Lookup> {

  int _short = 0;
  bool _searchMode = true;
  Icon _appIcon = const Icon(Icons.search, size: 32.0,);
  final TextEditingController _searchText = TextEditingController();

  @override
  Widget build(BuildContext context) {
    // if (this.widget.parameter!["kriteria"])
    // bool kriteriaExist = this.widget.parameter!.containsKey("kriteria");

    // if(!kriteriaExist){

    // }

    return Scaffold(
      appBar: AppBar(
            title: _searchWidget(),
            actions: <Widget>[
              IconButton(
                icon: _appIcon,
                onPressed: () {
                  _searchMode = _searchMode ? false: true;
                  _searchText.text = "";
                  setState(() => _appIcon = _searchMode ? const Icon(Icons.search) : const Icon(Icons.close));                  
                },
              ),

              IconButton(
                icon: const Icon(Icons.import_export, size: 32,),
                onPressed: (){
                  _short = _short == 0 ? 1 : 0;
                  setState((){});
                },
              )
            ],
      ),
      body: Container(
        child: FutureBuilder(
          future: widget.datamodel.getLookup(widget.parameter),
          builder: (context,AsyncSnapshot<Map> snapshot) {
            if (snapshot.hasError) print(snapshot.error);
            return snapshot.hasData
                ? RefreshIndicator(
                    onRefresh: ()=> _refreshData(),
                    child: ListView.builder(
                      itemCount: snapshot.data == null ? 0 :snapshot.data!["data"].length,
                      itemBuilder: (context, index) {
                        return Card(
                          child: ListTile(
                            //leading: Icon(Icons.check_circle_outline, color: Theme.of(context).primaryColor,),
                            title: Text(snapshot.data!["data"][index]['Title'],  style: TextStyle(
                                                                              color: Theme.of(context).primaryColorDark,
                                                                              fontWeight:FontWeight.bold
                                                                              ),
                            ),
                            subtitle: Text(snapshot.data!["data"][index]["ID"]),
                            onTap: (){
                              Navigator.pop(context, {
                                "ID" : snapshot.data!["data"][index]['ID'],
                                "Title" : snapshot.data!["data"][index]['Title']
                              });
                            },
                          ),
                        );
                      }
                    ),
                  )
                : const Center(
                      child: CircularProgressIndicator(),
                  );
          },
        )
      ),
    );
  }
  
  Widget _searchWidget() {
    if(_searchMode) {
      return Text(widget.title);
    }else {
      return (
        Container(
          color: Theme.of(context).primaryColorLight,
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: TextField(
              controller: _searchText,
              autofocus: true,
              decoration: const InputDecoration.collapsed(hintText: "Cari Data"),
              textInputAction: TextInputAction.search,
              onChanged: (value) => setState((){
                widget.parameter!.putIfAbsent("kriteria", ()=>_searchText.text);
              })
            ),
          )
        )
      );
    }
  }

  Widget _itemData(List list) {
    return RefreshIndicator(
          onRefresh: ()=> _refreshData(),
          child: ListView.builder(
          itemCount: list == null ? 0 : list.length,
          itemBuilder: (context, index) {
            return Card(
                      child: ListTile(
                        //leading: Icon(Icons.check_circle_outline, color: Theme.of(context).primaryColor,),
                        title: Text(list[index]['Title'],  style: TextStyle(
                                                                          color: Theme.of(context).primaryColorDark,
                                                                          fontWeight:FontWeight.bold
                                                                          ),
                        ),
                        onTap: (){
                          Navigator.pop(context, {
                            "ID" : list[index]['ID'],
                            "Title" : list[index]['Title']
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

      Completer<void> completer = Completer<void>();
      Future.delayed(const Duration(seconds: 1)).then( (_) {
        completer.complete();
      });
      return completer.future;
  }

}
