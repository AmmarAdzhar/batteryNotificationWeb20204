const admin = require('firebase-admin');
const express = require('express');
const bodyParser = require('body-parser');

admin.initializeApp({
    credential: admin.credential.cert(require('./your-service-account-file.json'))
});

const app = express();
app.use(bodyParser.json());

app.post('/batteryNotification', (req, res) => {
    const registrationToken = req.body.token;
    const message = {
        notification: {
            title: 'Battery Notification',
            body: 'Battery level is above 20%',
        },
        token: registrationToken,
        priority: 'high'
    };

    admin.messaging().send(message)
        .then((response) => {
            res.json({ success: true, response });
        })
        .catch((error) => {
            res.status(500).send('Error sending message: ' + error);
        });
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});
