import 'dart:html' as html;
import 'dart:math';
import 'package:flutter/material.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/Config/urlParamter.dart';
import 'package:xposmenu/Pages/ListMenu.dart';

Future<void> main() async {
  maximizeWindow();
  runApp(MainApp());
}

void maximizeWindow() {
  html.window.moveTo(Point(0, 0));
  html.window.resizeTo(html.window.screen!.width!, html.window.screen!.height!);
}

class MainApp extends StatelessWidget {

  @override
  Widget build(BuildContext context) {
    Session sess = Session();
    urlParameter xParam = new urlParameter();
    sess = xParam.getParameter(context);
    return MaterialApp(home: ListMenu(sess));
  }
}
