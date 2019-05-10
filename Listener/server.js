const express = require('express');

const app = express();

// Parse URL-encoded bodies (as sent by HTML forms)
app.use(express.urlencoded());

// Parse JSON bodies (as sent by API clients)
app.use(express.json());

app.listen(2000, () => {
    console.log("server listening on port 2000");
});

app.post('/tchat', function(req, res) {
    console.log(req.body);
    //res.setHeader('Content-Type', 'application/json');
    res.send('ok');
});