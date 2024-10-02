import 'dart:convert';
import 'dart:html';
import 'package:flutter/material.dart';
import 'package:xposmenu/Config/Session.dart';
/**
 * Usage Class urlParameter
 * 
 * 1. Class ini akan di akses melalui main.dart sebelum load MyApp
 * 2. Yang akan dilakukan di class ini antara lain :
 *      a. Mengambil URL Parameter yang di parsing dari Portal, (FeatureID, ObjectString)
 *      b. Convert FeatureID ke Widget dengan Method "AppModule" dengan paramter "session" dan FeatureID dari URL
 *      c. Convert ObjectString ke Map<String, Dynamic>
 *      d. Set Session
 */
class urlParameter {
  Session getParameter(BuildContext context) {
    Session sess = Session();

    var orientation = MediaQuery.of(context).orientation;
    sess.width =  MediaQuery.of(context).size.width / 100;
    sess.hight = MediaQuery.of(context).size.height / 100;
    sess.orientation = orientation;

    print("Width : "+ sess.width.toString() + "Hight : " + sess.hight.toString() + " Orientasi " + orientation.name);

    List<int> base64Decode(String encodedString) {
      return base64.decode(encodedString);
    }

    var uri = Uri.dataFromString(window.location.href);
    Map<String, String> params = uri.queryParameters;

    if (params.length > 0) {

      if (params['ObjectString'].toString() != "") {
        String ObjectString = Uri.decodeComponent(params['ObjectString'].toString());
        // Decoding
        String Object = utf8.decode(base64Decode(ObjectString));
        Map<String, dynamic> oDataParam = jsonDecode(Object);

        sess.RecordOwnerID = oDataParam["RecordOwnerID"];
        sess.PartnerName = oDataParam["PartnerName"];
        sess.KodeMeja = oDataParam["KodeMeja"];
        sess.NamaMeja = oDataParam["NamaMeja"];
        sess.DeviceID = oDataParam["DeviceID"];
        sess.IPAddress = oDataParam["IPAddress"];
      }
    }
    else{
      sess.RecordOwnerID = "CL0002";
      sess.PartnerName = "TEST DATA";
      sess.KodeMeja = "A1";
      sess.NamaMeja = "A1";
      sess.DeviceID = "ASDASD";
      sess.IPAddress = "180.25.215.22";
    }

    return sess;
  }
}
