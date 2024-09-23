import 'package:flutter/material.dart';


Future messageDialog({required BuildContext context, required String title, required String message}) async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: const EdgeInsets.all(5),
          contentPadding: const EdgeInsets.fromLTRB(5, 15, 5, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: const TextStyle(color: Colors.white),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                Center(child: Text(message)),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: const Text('Ya'),
              onPressed: () {
                Navigator.of(context).pop(true);
              },
            ),
            TextButton(
              child: const Text('Batal'),
              onPressed: () {
                Navigator.of(context).pop(false);
              },
            ),
          ],
        );
      },
    );
  }

  Future messageBox({required BuildContext context,required String title,required String message}) async {
    return showDialog<void>(
      context: context,
      barrierDismissible: false, // user must tap button!
      builder: (BuildContext context) {
        return AlertDialog(
          titlePadding: const EdgeInsets.all(5),
          contentPadding: const EdgeInsets.fromLTRB(5, 15, 5, 15),
          title: Container(
              width: double.infinity,
              height: 30,
              color: Theme.of(context).primaryColorDark,
              child: Center(child: Text(title, style: const TextStyle(color: Colors.white),))
          ),
          content: SingleChildScrollView(
            child: ListBody(
              children: <Widget>[
                Padding(
                  padding: const EdgeInsets.all(15),
                  child: Center(child: Text(message)),
                ),
              ],
            ),
          ),
          actions: <Widget>[
            TextButton(
              child: const Text('Tutup'),
              onPressed: () {
                Navigator.of(context).pop();
              },
            ),
          ],
        );
      },
    );
  }

  
Future<void> showLoadingDialog(BuildContext context, GlobalKey key, {required String info}) async {
    return showDialog<void>(
        context: context,
        barrierDismissible: false,
        builder: (BuildContext context) {
          return WillPopScope(
              onWillPop: () async => false,
              child: SimpleDialog(
                  key: key,
                  backgroundColor: Colors.black54,
                  children: <Widget>[
                    Center(
                      child: Column(children: [
                        const CircularProgressIndicator(),
                        const SizedBox(height: 10,),
                        Text("Please Wait :$info",style: const TextStyle(color: Colors.blueAccent),)
                      ]),
                    )
                  ]));
        });
  }