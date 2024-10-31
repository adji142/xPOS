import 'dart:async';

import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/main.dart';

class FinishCheckout extends StatefulWidget {
  Session? session;
  double? TotalPesan;
  FinishCheckout(this.session, this.TotalPesan);

  @override
  _FinishCheckoutState createState() => _FinishCheckoutState();
}

class _FinishCheckoutState extends State<FinishCheckout> {
  final GlobalKey<State> _keyLoader = new GlobalKey<State>();

  @override
  void initState() {
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final formatter = NumberFormat('#,##0.##');

    return Scaffold(
      body: SingleChildScrollView(
        child: Column(
          children: [
            Center(
              child: Image.asset('assets/done.gif'),
            ),
            Center(
              child: Text(
              "Silahkan Membayar ke Kasir Sebesar",
              textAlign: TextAlign.center,
                style: TextStyle(
                  fontSize: this.widget.session!.width! * 6,
                  color: Colors.green,
                ),
              ),
            ),
            Text(
              formatter.format(this.widget.TotalPesan),
              style: TextStyle(
                fontSize: this.widget.session!.width! * 8,
                color: Colors.red,
                fontWeight: FontWeight.bold
              ),
            ),
            ElevatedButton(
              onPressed:() async{
                Navigator.pushReplacement(context,MaterialPageRoute(builder: (context) => MainApp()));
              },
              child: Text(
                "KEMBALI KE DAFTAR MENU",
                style: TextStyle(
                  fontSize: this.widget.session!.width! * 4,
                  color: Colors.red,
                  fontWeight: FontWeight.bold
                ),
              )
            ),
          ],
        ),
      ),
    );
  }
}
