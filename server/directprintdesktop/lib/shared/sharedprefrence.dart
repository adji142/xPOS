import 'package:shared_preferences/shared_preferences.dart';

class SharedPreference {
  setString(String Key, String value) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.setString(Key, value);
  }

  Future<String> getString(String Key) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    return preferences.getString(Key) ?? "";
  }

  Future<bool> removeKey(String KeyRemove) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    return preferences.remove(KeyRemove);
  }
}
