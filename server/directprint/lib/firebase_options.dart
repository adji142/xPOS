// File generated by FlutterFire CLI.
// ignore_for_file: type=lint
import 'package:firebase_core/firebase_core.dart' show FirebaseOptions;
import 'package:flutter/foundation.dart'
    show defaultTargetPlatform, kIsWeb, TargetPlatform;

/// Default [FirebaseOptions] for use with your Firebase apps.
///
/// Example:
/// ```dart
/// import 'firebase_options.dart';
/// // ...
/// await Firebase.initializeApp(
///   options: DefaultFirebaseOptions.currentPlatform,
/// );
/// ```
class DefaultFirebaseOptions {
  static FirebaseOptions get currentPlatform {
    if (kIsWeb) {
      return web;
    }
    switch (defaultTargetPlatform) {
      case TargetPlatform.android:
        return android;
      case TargetPlatform.iOS:
        return ios;
      case TargetPlatform.macOS:
        return macos;
      case TargetPlatform.windows:
        return windows;
      case TargetPlatform.linux:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for linux - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      default:
        throw UnsupportedError(
          'DefaultFirebaseOptions are not supported for this platform.',
        );
    }
  }

  static const FirebaseOptions web = FirebaseOptions(
    apiKey: 'AIzaSyBJnDcCEd8SbByWiZJzjMgz48tgtpK7bWs',
    appId: '1:393229246326:web:eaf5c3e0b36f22a562a457',
    messagingSenderId: '393229246326',
    projectId: 'receiptprinter-89dc0',
    authDomain: 'receiptprinter-89dc0.firebaseapp.com',
    storageBucket: 'receiptprinter-89dc0.appspot.com',
    measurementId: 'G-BQDM6ZNN27',
  );

  static const FirebaseOptions android = FirebaseOptions(
    apiKey: 'AIzaSyBLvJ5xbRKX5cO0-xLmj4Zjfew9nknpyVc',
    appId: '1:393229246326:android:360be9d0320262d562a457',
    messagingSenderId: '393229246326',
    projectId: 'receiptprinter-89dc0',
    storageBucket: 'receiptprinter-89dc0.appspot.com',
  );

  static const FirebaseOptions ios = FirebaseOptions(
    apiKey: 'AIzaSyCwhrG0Pzb6_-Si29OR5XxPGU-MgKI3pLs',
    appId: '1:393229246326:ios:37c4aa4ba2391b7162a457',
    messagingSenderId: '393229246326',
    projectId: 'receiptprinter-89dc0',
    storageBucket: 'receiptprinter-89dc0.appspot.com',
    androidClientId: '393229246326-cn3d3au0io6jcd5urvam2lfpa0n3tpvl.apps.googleusercontent.com',
    iosBundleId: 'com.example.directprint',
  );

  static const FirebaseOptions macos = FirebaseOptions(
    apiKey: 'AIzaSyCwhrG0Pzb6_-Si29OR5XxPGU-MgKI3pLs',
    appId: '1:393229246326:ios:37c4aa4ba2391b7162a457',
    messagingSenderId: '393229246326',
    projectId: 'receiptprinter-89dc0',
    storageBucket: 'receiptprinter-89dc0.appspot.com',
    androidClientId: '393229246326-cn3d3au0io6jcd5urvam2lfpa0n3tpvl.apps.googleusercontent.com',
    iosBundleId: 'com.example.directprint',
  );

  static const FirebaseOptions windows = FirebaseOptions(
    apiKey: 'AIzaSyBJnDcCEd8SbByWiZJzjMgz48tgtpK7bWs',
    appId: '1:393229246326:web:fe9e0941ad3e1b1862a457',
    messagingSenderId: '393229246326',
    projectId: 'receiptprinter-89dc0',
    authDomain: 'receiptprinter-89dc0.firebaseapp.com',
    storageBucket: 'receiptprinter-89dc0.appspot.com',
    measurementId: 'G-KQGD5HQHPY',
  );
}