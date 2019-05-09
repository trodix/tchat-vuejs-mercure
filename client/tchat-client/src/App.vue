<template>
  <div id="app">
    <div class="input">
      <input type="text" v-model="newMsg.body" placeholder="your message">
      <button @click.prevent="sendMsg()">Send</button>
    </div>
    <div class="wrapper">
      <h1>Messages du tchat</h1>
      <div class="messages" v-if="messages.length > 0">
        <div class="msg" v-for="msg in messages" :key="msg.id">
          {{ msg.body }}
          <small>published by {{ msg.user }} at {{ msg.createdAt.date }}</small>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
const $axios = axios.create({
  headers: {
    //'Access-Control-Allow-Origin': '*',
    'Content-Type': 'application/json;charset=UTF-8',
  },
  mode: 'no-cors',
});
const hub_url = 'http://127.0.0.1:3000/hub';
const api_url = 'http://127.0.0.1:8000/tchat';

export default {
  name: 'app',
  data() {
    return {
      messages: [],
      newMsg: {
        body: "",
        user: "Sébastien Vallet"
      }
    }
  },
  created() {
    const url = new URL(hub_url);
    url.searchParams.append('topic', api_url); // sujet à écouter

    const eventSource = new EventSource(url, {withCredentials: false});

    // The callback will be called every time an update is published
    //eventSource.onmessage = e => console.log(e); // do something with the payload

    eventSource.onmessage = e => {
      // Will be called every time an update is published by the server
      console.log(e, JSON.parse(e.data));
      const message = JSON.parse(e.data);
      if(message) {
        this.messages.push(message);
      }
    };
  },
  methods: {
    sendMsg() {
      const data = (JSON.stringify(this.newMsg));

      $axios.post(api_url, data).then((data) => {
        console.log(`#success: ${data}`);
      }).catch((err) => {
        console.log(`#error: ${err.message}`);
      });
    }
  },
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.input {
  margin: 20px auto;
  display: flex;
  flex-direction: row;
}
</style>

<style scope>
.wrapper {
  min-height: 200px;
  min-width: 200px;
  max-width: 400px;  
  display: flex;
  flex-direction: column;
}

.messages {
  background-color: lightgrey;
  padding: 20px 20px;
}

.msg {
  display: flex;
  flex-direction: column;
  font-size: 1.2em;
  border-bottom: 1px solid grey;
  padding: 15px 10px;
}

.msg > small {
  font-size: 0.6em;
}

</style>
