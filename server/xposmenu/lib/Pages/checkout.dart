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

  double _calculateTotal(){
    double xTotal = 0;
    // Hitung Normal
    print(this.widget.items);
    for (var i = 0; i < this.widget.items.length; i++) {
      xTotal += (this.widget.items[i]["Qty"] * this.widget.items[i]["Price"]);

      // Variant
      for (var x = 0; x < this.widget.items[i]["Variant"].length; x++) {
        xTotal += this.widget.items[i]["Variant"][x]["ExtraPrice"];
      }
      // Addon
      for (var y = 0; y < this.widget.items[i]["Addon"].length; y++) {
        xTotal += this.widget.items[i]["Addon"][y]["HargaAddon"];
      }
    }
    print(xTotal);
    return xTotal;
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
                                  print(this.widget.items[index]["Variant"]);
                                  if (snapshot.data!["variant"].length > 0) {
                                    return item["Variant"].length < item["Qty"] ? GestureDetector(
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
                                        if (result != null) {
                                          // var xData = snapshot.data!["variant"].where((item) => item['VariantID'] == result["ID"]).toList();
                                          // print(this.widget.items[index]["Variant"]);
                                          setState(() {
                                            this.widget.items[index]["Variant"].add(snapshot.data!["variant"].where((item) => item['VariantID'] == result["ID"]).toList()[0]);
                                          });
                                        }
                                      },
                                    ): Container();
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
                            Container(
                              child: Column(
                                children: [
                                  for (int i = 0; i < this.widget.items[index]["Variant"].length; i++)
                                    Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text("1 x " + this.widget.items[index]["Variant"][i]["NamaVariant"]),
                                        Text(NumberFormat.currency(symbol: "Rp").format(this.widget.items[index]["Variant"][i]["ExtraPrice"]))
                                      ],
                                    )
                                ],
                              )
                            ),
                            SizedBox(height: 5),
                            Divider(),
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                Text(qty.toString() +" x " + NumberFormat('#,##0').format(price).toString()),
                                Text(NumberFormat.currency(symbol: "Rp").format(totalPrice))
                              ],
                            ),
                            SizedBox(height: 5),
                            Divider(),
                            FutureBuilder(
                              future: initialModel(this.widget.sess, {"KodeItem":item["KodeItem"],"RecordOwnerID":this.widget.sess.RecordOwnerID}).getVariantAddon(), 
                              builder: (context, snapshot){
                                if (snapshot.hasData) {
                                  if (snapshot.data!["addon"].length > 0) {
                                    return GestureDetector(
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
                                      onTap: ()async{
                                        var result = await Navigator.push(context,MaterialPageRoute(builder: (context) => Lookup("Addon Menu",new initialModel(this.widget.sess,{}),idRetValue: "AddonMenuID",titleRetValue: "NamaAddon",oOptionalList: snapshot.data!["addon"], Subtitle: "HargaAddon", subtitleType: 1,)),);
                                        if (result != null) {
                                          // var xData = snapshot.data!["variant"].where((item) => item['VariantID'] == result["ID"]).toList();
                                          // print(this.widget.items[index]["Variant"]);
                                          setState(() {
                                            this.widget.items[index]["Addon"].add(snapshot.data!["addon"].where((item) => item['AddonMenuID'] == result["ID"]).toList()[0]);
                                          });
                                        }
                                      },
                                    );
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
                            Container(
                              child: Column(
                                children: [
                                  for (int i = 0; i < this.widget.items[index]["Addon"].length; i++)
                                    Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        Text(
                                          "1 x " + this.widget.items[index]["Addon"][i]["NamaAddon"],
                                          style: TextStyle(
                                            color: Colors.red
                                          ),
                                        ),
                                        Text(
                                          NumberFormat.currency(symbol: "Rp").format(this.widget.items[index]["Addon"][i]["HargaAddon"]),
                                          style: TextStyle(
                                            color: Colors.red
                                          ),
                                        )
                                      ],
                                    )
                                ],
                              )
                            ),
                            // if (item['Variant'] != null && item['Variant'].isNotEmpty)
                            //   Text('Variant: ${item['Variant'].join(', ')}'),
                            // if (item['Addon'] != null && item['Addon'].isNotEmpty)
                            //   Text('Add-ons: ${item['Addon'].join(', ')}'),
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
              'Total: Rp. ${NumberFormat('#,##0').format(_calculateTotal())}',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                // Implement checkout logic here
                // For example, navigate to payment page or API call
                Navigator.pop(context); // or any other logic
              },
              child: Text('Proses Pesanan'),
            ),
          ],
        ),
      ),
    );
  }
}