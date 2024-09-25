import 'package:flutter/material.dart';

class Session {
  // String server = "http://patroli.aissystem.org/"; // Production
  // String server = "http://192.168.43.20:8080/patrolisiap86/"; // Development 1
  String server = "http://192.168.1.66/xpos/api/"; // Development 2
  // String server = "http://192.168.10.66:8080/patrolisiap86/"; // Development 3
  // String server = "http://192.168.127.190:8080/patrolisiap86/"; // Development 4
  // String server = "http://192.168.10.222:8080/patrolisiap86/"; // Development 4
  // String server = "http://192.168.1.2:8080/patrolisiap86/"; // Development 5

  int idUser = -1;
  String KodeUser = "";
  String NamaUser = "";
  String Email = "";
  String Token = "";
  String RecordOwnerID = "";
  String NamaPartner = "";
  String icon = "";
  int LocationID = -1;
  int roleID = -1;
  double hight = 0;
  double width = 0;
  String orientation = "";
  int interval = 0;
  String shift = "";
  int isGantiHari = 0;
  List jadwalShift = [];
  String payLoad = "";
  Color textColor = const Color(0xFF000031);
  Color lightTextColor = const Color(0xFF9f8b82);
  String appVersion = "1.0.6 B 1";
}
