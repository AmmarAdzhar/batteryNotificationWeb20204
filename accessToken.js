const admin = require('firebase-admin');
const express = require('express');
const bodyParser = require('body-parser');

// Initialize the app with a service account, granting admin privileges
admin.initializeApp({
    credential: admin.credential.cert(require('./your-service-account-file.json'))
});

const app = express();
app.use(bodyParser.json());

app.post('/accessToken', (req, res) => {
    const token = req.body.token;

    admin.auth().verifyIdToken(token)
        .then((decodedToken) => {
            const uid = decodedToken.uid;
            res.json({ uid });
        })
        .catch((error) => {
            res.status(403).send('Unauthorized');
        });
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});
