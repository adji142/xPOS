const express = require('express');
const noble = require('noble');
const app = express();
const port = 3000;

let devices = [];

noble.on('stateChange', (state) => {
    if (state === 'poweredOn') {
        noble.startScanning();
    } else {
        noble.stopScanning();
    }
});

noble.on('discover', (peripheral) => {
    devices.push({
        id: peripheral.id,
        address: peripheral.address,
        name: peripheral.advertisement.localName,
    });
});

app.get('/scan', (req, res) => {
    devices = [];
    noble.startScanning([], true);
    setTimeout(() => {
        noble.stopScanning();
        res.json(devices);
    }, 5000); // Scan for 5 seconds
});

app.get('/connect/:id', (req, res) => {
    const deviceId = req.params.id;
    const peripheral = noble._peripherals[deviceId];

    if (peripheral) {
        peripheral.connect((error) => {
            if (error) {
                res.status(500).json({ error: 'Failed to connect' });
            } else {
                res.json({ message: 'Connected' });
            }
        });
    } else {
        res.status(404).json({ error: 'Device not found' });
    }
});

app.listen(port, () => {
    console.log(`Bluetooth service running on port ${port}`);
});