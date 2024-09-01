const admin = require('firebase-admin');
const express = require('express');
const bodyParser = require('body-parser');

admin.initializeApp({
    credential: admin.credential.cert(require('./your-service-account-file.json'))
});

const app = express();
app.use(bodyParser.json());

app.post('/batteryNotification', (req, res) => {
    const registrationToken = "f2VoLxguR668dmMfKOg55e:APA91bE6Co6vx6qFsXcWko1fqhUHPY5lTkx1aSHv__MOvKaJoqLRxo-raMzyJrA3N-PNPSfI68Fq6MzxHsevKj2wKApPNNJp7yhqCdIJjryhxipp8an-O_5xYN0yhOQF7wuP1NnGMq-m";
    const message = {
        notification: {
            title: 'Battery Notification',
            body: 'Battery level is above 20%',
        },
        token: registrationToken,
        priority: "high"
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
