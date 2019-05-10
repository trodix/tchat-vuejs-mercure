<template>
  <div id="app">
    <div class="container tchat">
      <div class="toolbar">
        <input type="text" v-model="newMsg.user" placeholder="your username">
        <div class="input-message">
          <input type="text" v-model="newMsg.body" placeholder="your message">
          <button @click.prevent="sendMsg()">Send</button>
        </div>
      </div>
      <div class="wrapper">
        <h1>Messages du tchat</h1>
        <div class="messages">
          <div class="msg" v-for="msg in messages" :key="msg.id">
            <div class="msg-content">
              {{ msg.body }}
            </div>
            <small>published by {{ msg.user }} at {{ msg.createdAt.date }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
const $axios = axios.create({
  headers: {
    'Access-Control-Allow-Origin': 'http://127.0.0.1:8080,http://192.168.0.40:8080',
    'Content-Type': 'application/json;charset=UTF-8',
  },
  mode: 'no-cors',
});
const hub_url = 'http://192.168.0.44:3000/hub';
const api_url = 'http://192.168.0.40:8000/tchat';
const topic   = 'http://192.168.0.40:8000/tchat';

export default {
  name: 'app',
  data() {
    return {
      messages: [],
      newMsg: {
        body: "",
        user: ""
      }
    }
  },
  created() {
    const url = new URL(hub_url);
    url.searchParams.append('topic', topic); // sujet à écouter

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
      if (this.newMsg.user == "") {
        this.newMsg.user = "Unknown user"
      }
      const data = (JSON.stringify(this.newMsg));
      this.newMsg.body = "";

      $axios.post(api_url, data).then((res) => {
        console.log(`#success: ${res}`)
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
  color: #2c3e50;
  margin-top: 60px;
}
</style>

<style scope>
.container {
  margin: 10px 15px;
  min-width: 250px;
}
.tchat {
  background-color: #ff8f00;
  color: black;
  padding: 10px 10px;
  display: flex;
  flex-direction: column;
  border: 2px solid dimgray;
}
.toolbar {
  display: flex;
  flex-direction: column;
  margin: 20px 5px;
  max-width: 400px;  
}
.input-message {
  margin: 20px 5px;
  display: flex;
  flex-direction: row;
}
.input-message > input {
  width: 100%;
}
.wrapper {
  min-height: 200px;
  min-width: 200px;
  max-width: 400px;  
  display: flex;
  flex-direction: column;
}

h1 {
  font-size: 1.5em;
  text-align: center;
  color: #fafafa;
}

.messages {
  background-color: #fafafa;
  padding: 10px 10px;
  max-height: 300px;
  height: 300px;
  overflow-y: scroll;
}

.msg {
  display: flex;
  flex-direction: column;
  border-bottom: 1px solid grey;
  padding: 15px 10px;
}

.msg-content {
  font-size: 1.2em;
}

.msg > small {
  font-size: 0.5em;
  color: grey;
  margin-top: 30px;
  font-style: italic;
}

input {
  border-radius: 5px;
  border: none;
  padding: 5px;
}

button {
  background-color: rgb(43, 180, 54);
  border: none;
  border-radius: 5px;
  padding: 5px 10px;
  color: #ffffff;
  font-weight: 700;
}

</style>
