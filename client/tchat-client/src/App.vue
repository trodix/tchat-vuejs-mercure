<template>
  <div id="app">
    <div id="output"></div>
    <button @click.prevent="getUpdate()">Get update</button>
  </div>
</template>

<script>

export default {
  name: 'app',
  data() {
    return {

    }
  },
  created() {
    const url = new URL('http://192.168.0.38:3000/hub');
    url.searchParams.append('topic', 'http://localhost:8000/tchat'); // sujet à écouter

    const eventSource = new EventSource(url, {withCredentials: true});

    // The callback will be called every time an update is published
    //eventSource.onmessage = e => console.log(e); // do something with the payload

    eventSource.onmessage = e => {
        // Will be called every time an update is published by the server
        console.log(JSON.parse(e.data));
        const data = JSON.parse(e.data);
        if(data.status) {
            document.querySelector('#output').innerHTML = `Data: ${data}`;
        }
    };
  },
  methods: {
    getUpdate() {
      const init = { 
        method: 'POST',
        mode: 'no-cors',
        withCredentials: true,
        credentials: 'include',
        headers: {
            'Authorization': "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtZXJjdXJlIjp7InB1Ymxpc2giOlsiKiJdfX0.NFCEbEEiI7zUxDU2Hj0YB71fQVT8YiQBGQWEyxWG0po",
        }
    };

    fetch(`http://localhost:8000/tchat`, init);
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
</style>
