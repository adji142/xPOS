// import 'package:directprintdesktop/home.dart';
import 'package:directprintdesktop/models/auth.dart';
import 'package:directprintdesktop/shared/Session.dart';
import 'package:directprintdesktop/shared/dialog.dart';
import 'package:directprintdesktop/shared/sharedprefrence.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';

class LoginPage extends StatefulWidget {
  final Session ? sess;
  const LoginPage(this.sess, {super.key});

  @override
  _LoginPageState createState() => _LoginPageState();
}
class _LoginPageState extends State<LoginPage> {
  final TextEditingController _Email = TextEditingController();
  final TextEditingController _Password = TextEditingController();
  final GlobalKey<State> _keyLoader = GlobalKey<State>();

  @override
  void initState(){
    super.initState();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: SingleChildScrollView(
          padding: EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.network(
                'https://www.creativefabrica.com/wp-content/uploads/2020/07/08/LATTER-A-SIMPLE-LOGO-Graphics-4567365-1.jpg', // Replace with your logo URL or asset path
                height: 100,
              ),
              SizedBox(height: 40),
              TextField(
                controller: _Email,
                decoration: InputDecoration(
                  labelText: 'Email',
                  border: OutlineInputBorder(),
                ),
              ),
              SizedBox(height: 20),
              TextField(
                controller: _Password,
                decoration: InputDecoration(
                  labelText: 'Password',
                  border: OutlineInputBorder(),
                  suffixIcon: Icon(Icons.visibility),
                ),
                obscureText: true,
              ),
              SizedBox(height: 20),
              Row(
                children: [
                  Checkbox(value: true, onChanged: (value) {}),
                  Text('Keep me logged in'),
                ],
              ),
              SizedBox(height: 20),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: () async{
                    showLoadingDialog(context, _keyLoader, info: "Begin Login");

                    Map oParam() {
                    return {
                        "email": _Email.text,
                        "password": _Password.text,
                      };
                    }

                    Auth(sess: this.widget.sess, Parameter: oParam()).Login().then((value) async{
                      if (value["success"].toString() == "true") {
                        widget.sess!.idUser = value["data"]["id"];
                        widget.sess!.NamaUser = value["data"]["name"];
                        widget.sess!.Email = value["data"]["email"];
                        widget.sess!.RecordOwnerID = value["data"]["RecordOwnerID"];

                        var xShared = value["data"]["id"].toString() +"|" +value["data"]["name"] +"|" +value["data"]["email"] +"|" +value["data"]["RecordOwnerID"];
                        SharedPreference().setString("accountInfo", xShared);

                        var message = FirebaseMessaging.instance;

                        await message.getToken().then((value) {
                          widget.sess!.Token = value.toString();
                          print(value);
                        });

                        Navigator.of(context, rootNavigator: true).pop();
                        // Navigator.pushReplacement(context,MaterialPageRoute(builder: (context) =>DashboardPage(widget.sess))); 
                      }
                    }); 
                  },
                  child: Text('Login'),
                  style: ElevatedButton.styleFrom(
                    padding: EdgeInsets.symmetric(vertical: 15),
                  ),
                ),
              ),
              SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }
}