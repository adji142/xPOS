import 'package:directprint/home.dart';
import 'package:directprint/login.dart';
import 'package:directprint/shared/Session.dart';
import 'package:directprint/shared/sharedprefrence.dart';
import 'package:flutter/material.dart';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'firebase_options.dart';

final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin = FlutterLocalNotificationsPlugin();

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
  print('Handling a background message ${message.messageId}');
  print(message);
}

Future<void> init() async {
  const AndroidInitializationSettings androidInitializationSettings = AndroidInitializationSettings('app_icon');

  const InitializationSettings initializationSettings = InitializationSettings(android: androidInitializationSettings);
  await flutterLocalNotificationsPlugin.initialize(initializationSettings);
}

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform,);
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  await FirebaseMessaging.instance.setForegroundNotificationPresentationOptions(
    alert: true,
    badge: true,
    sound: true,
  );

  NotificationSettings setting = await FirebaseMessaging.instance.requestPermission(
    alert: true,
    announcement: false,
    badge: true,
    carPlay: false,
    criticalAlert: false,
    provisional: false,
    sound: true,
  );

  print('User granted permission: ${setting.authorizationStatus}');
  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  static final GlobalKey<NavigatorState> navigatorKey = GlobalKey<NavigatorState>();
  const MyApp({super.key});

  @override
  _MainState createState() => _MainState();

}
class _MainState extends State<MyApp> {
  Session sess = Session();

  @override
  void initState(){
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    var width = MediaQuery.of(context).size.width / 100;
    var height = MediaQuery.of(context).size.height / 100;
    
    setState(() {
      sess.hight = height;
      sess.width = width;
    });

    ThemeData themeData(bool isDarkMode, BuildContext context) {
      return ThemeData(
        primaryColor: const Color(0xFF125389),
        indicatorColor: isDarkMode ? const Color(0xFF0E1D36) : const Color(0xFF226f54),
        hintColor: isDarkMode ? const Color(0xFF280C0B) : const Color(0xff133762),
        highlightColor: isDarkMode ? const Color(0xFF372901) : const Color(0xff133762),
        hoverColor: isDarkMode ? const Color(0xFF3A3A3B) : const Color(0xff133762),
        focusColor: isDarkMode ? const Color(0xFF0B2512) : const Color(0xff133762),
        disabledColor: Colors.grey,
        cardColor: isDarkMode ? const Color(0xFF151515) : Colors.white,
        // canvasColor: Color(0xFF000031),
        brightness: isDarkMode ? Brightness.dark : Brightness.light,
        buttonTheme: Theme.of(context).buttonTheme.copyWith(
            colorScheme: isDarkMode ? const ColorScheme.dark() : const ColorScheme.light()),
        appBarTheme: const AppBarTheme(
          elevation: 0,
        ),
        // dividerColor: Colors.transparent, colorScheme: ColorScheme(background: isDarkMode ? Colors.black : const Color(0xFFF1F5FB))
      );
    }

    return MaterialApp(
      title: 'Direct Printer Thermal',
      theme: themeData(false, context),
      home: FutureBuilder(
        future: SharedPreference().getString("accountInfo"),
        builder: (context, snapshot) {
          if (snapshot.hasData && snapshot.data != "") {
            var xData = snapshot.data!.split("|");
            sess.idUser = int.parse(xData[0]);
            sess.NamaUser = xData[1];
            sess.Email = xData[2];
            sess.RecordOwnerID = xData[3];

            return DashboardPage(sess);
            // return Container();
          }
          else{
            return LoginPage(sess);
          }
        }
      )
    );
  }
}