import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:xposmenu/Config/Session.dart';
import 'package:xposmenu/Models/initialModel.dart';
import 'package:xposmenu/Shared/Lookup.dart';

class CheckoutPage extends StatefulWidget {
  final Session sess;
  final List items;
  CheckoutPage(this.sess, this.items);
  @override
  _checkoutState createState() => _checkoutState();
}
class _checkoutState extends State<CheckoutPage> {
  List _variantMenu = [];
  List _addonMenu = [];

  _GetVariantData(String KodeItem) async {
    for (var i = 0; i < this.widget.items.length; i++) {
      if (this.widget.items[i]["Qty"] > 0) {
        var tempVariant = await initialModel(this.widget.sess, {"KodeItem":KodeItem}).getVariantAddon();
        _variantMenu.add({this.widget.items[i]["KodeItem"]:tempVariant["variant"]});
        _addonMenu.add({this.widget.items[i]["KodeItem"]:tempVariant["addon"]});
      }
    }
    
    // return temp["data"];
  }

  @override
  Widget build(BuildContext context) {
    double totalCost = 0.0;

    return Scaffold(
      appBar: AppBar(
        title: Text('Checkout'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Order Summary',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            Expanded(
              child: ListView.builder(
                itemCount: this.widget.items.length,
                itemBuilder: (context, index) {
                  final item = this.widget.items[index];
                  final price = item['Price'] as double;
                  final qty = item['Qty'] as int;
                  final totalPrice = price * qty;
                  totalCost += totalPrice;

                  if (qty > 0) {
                    return Card(
                      margin: EdgeInsets.symmetric(vertical: 8.0),
                      child: Padding(
                        padding: const EdgeInsets.all(16.0),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Menu : ${item['NamaItem']}',
                              style: TextStyle(fontWeight: FontWeight.bold),
                            ),
                            FutureBuilder(
                              future: initialModel(this.widget.sess, {"KodeItem":item["KodeItem"],"RecordOwnerID":this.widget.sess.RecordOwnerID}).getVariantAddon(), 
                              builder: (context, snapshot){
                                if (snapshot.hasData) {
                                  if (snapshot.data!["variant"].length > 0) {
                                    return item["Variant"].length == 0 ? GestureDetector(
                                      child: Card(
                                        child: Padding(
                                          padding: EdgeInsets.only(top: 4, left: 10, right: 10, bottom: 2),
                                          child: Text(
                                            "Tambah Varian Menu",
                                            style: TextStyle(
                                              color: Colors.amber
                                            ),
                                          ),
                                        ),
                                      ),
                                      onTap: ()async{
                                        var result = await Navigator.push(context,MaterialPageRoute(builder: (context) => Lookup("Variant",new initialModel(this.widget.sess,{}),idRetValue: "VariantID",titleRetValue: "NamaVariant",oOptionalList: snapshot.data!["variant"],)),);
                                      },
                                    ):Container();
                                  }
                                  else{
                                    return Container();
                                  }
                                }
                                else{
                                  return Container(
                                    child: Center(
                                      child: CircularProgressIndicator(),
                                    ),
                                  );
                                }
                              }
                            ),
                            SizedBox(height: 5),
                            Text('Quantity: $qty'),
                            SizedBox(height: 5),
                            Text('Price: Rp. ${NumberFormat('#,##0').format(price)}'),
                            SizedBox(height: 5),
                            Divider(),
                            FutureBuilder(
                              future: initialModel(this.widget.sess, {"KodeItem":item["KodeItem"],"RecordOwnerID":this.widget.sess.RecordOwnerID}).getVariantAddon(), 
                              builder: (context, snapshot){
                                if (snapshot.hasData) {
                                  if (snapshot.data!["addon"].length > 0) {
                                    return item["Addon"].length == 0 ? GestureDetector(
                                      child: Card(
                                        child: Padding(
                                          padding: EdgeInsets.only(top: 4, left: 10, right: 10, bottom: 2),
                                          child: Text(
                                            "Tambah Addon",
                                            style: TextStyle(
                                              color: Colors.brown
                                            ),
                                          ),
                                        ),
                                      ),
                                    ):Container();
                                  }
                                  else{
                                    return Container();
                                  }
                                }
                                else{
                                  return Container(
                                    child: Center(
                                      child: CircularProgressIndicator(),
                                    ),
                                  );
                                }
                              }
                            ),
                            Text('Total: Rp. ${NumberFormat('#,##0').format(totalPrice)}'),
                            SizedBox(height: 5),
                            if (item['Variant'] != null && item['Variant'].isNotEmpty)
                              Text('Variant: ${item['Variant'].join(', ')}'),
                            if (item['Addon'] != null && item['Addon'].isNotEmpty)
                              Text('Add-ons: ${item['Addon'].join(', ')}'),
                          ],
                        ),
                      ),
                    ); 
                  }
                },
              ),
            ),
            Divider(),
            Text(
              'Total Cost: Rp. ${NumberFormat('#,##0').format(totalCost)}',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                // Implement checkout logic here
                // For example, navigate to payment page or API call
                Navigator.pop(context); // or any other logic
              },
              child: Text('Proceed to Payment'),
            ),
          ],
        ),
      ),
    );
  }
}