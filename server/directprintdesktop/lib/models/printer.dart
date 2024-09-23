import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:directprintdesktop/shared/Session.dart';

class PrinterData {
  Session? sess;
  Map? Parameter;

  PrinterData(this.sess, {this.Parameter});

  Future<Map> printerlist() async{
    var url = Uri.parse("${sess!.server}printerlist");
    final response = await http.post(url,body: Parameter);
    // print(response.body);
    return json.decode(response.body);
  }

  Future<Map> printerstore() async{
    var url = Uri.parse("${sess!.server}printerstore");
    final response = await http.post(url,body: Parameter);
    // print(response.body);
    return json.decode(response.body);
  }

  Future<Map> printeredit() async{
    var url = Uri.parse("${sess!.server}printeredit");
    final response = await http.post(url,body: Parameter);
    return json.decode(response.body);
  }

  Future<Map> printerdelete() async{
    var url = Uri.parse("${sess!.server}printerdelete");
    final response = await http.post(url,body: Parameter);
    return json.decode(response.body);
  }

}
