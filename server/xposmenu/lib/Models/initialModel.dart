import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:xposmenu/Config/Session.dart';

class initialModel {
  Session? sess;
  Map? Parameter;

  initialModel(this.sess, this.Parameter);

  Future<Map> initData() async {
    var url = Uri.parse("${sess!.Server}initWebMenu");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }
  Future<Map> getMenu()async{
    var url = Uri.parse("${sess!.Server}getMenu");
    final response = await http.post(url, body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> getVariantAddon()async{
    var url = Uri.parse("${sess!.Server}getAddon");
    final response = await http.post(url, body: Parameter);
    print(response.body);
    return json.decode(response.body);
  }

  Future<Map> SaveOrder()async{
    var url = Uri.parse("${sess!.Server}saveFromTable");
    final response = await http.post(url, headers: {'Content-Type': 'application/json',}, body: jsonEncode(Parameter));
    print(response.body);
    return json.decode(response.body);
  }
}
