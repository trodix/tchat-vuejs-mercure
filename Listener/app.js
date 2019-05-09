/**
 * NodeJs Listener
 */
const EventSource = require('eventsource');
// const express = require('express');

// const app = express();
// app.listen(2000);

const hub_url = 'http://192.168.0.44:3000/hub';
const api_url = 'http://127.0.0.1:8000/tchat';

const url = hub_url + '?topic=' + api_url; // sujet à écouter

const eventSource = new EventSource(url, {withCredentials: false});
console.log(`### Event source listening for topic ${url}`),
// The callback will be called every time an update is published
//eventSource.onmessage = e => console.log(e); // do something with the payload

eventSource.onmessage = e => {
    console.log('['+(new Date())+']');
    // Will be called every time an update is published by the server
    console.log(e, JSON.parse(e.data));
};