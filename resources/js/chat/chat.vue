<template>
  <el-row>
    <el-col :span="24">
      <div class="chat">
        <ul class="list-group">
          <li
            v-for="(item, index) in messages"
            :key="index"
            class="list-group-item disabled"
            aria-disabled="true"
          >
            {{ item.data.name }} : {{ item.data.content }} {{ item.data.time }}
          </li>
        </ul>
      </div>
    </el-col>
    <el-col :span="24">
      <el-form ref="form" :model="form" label-width="80px">
        <el-form-item label="活动形式">
          <el-input :rows="2" type="textarea" v-model="data"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">立即创建</el-button>
          <el-button>取消</el-button>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>
</template>

<script>
export default {
  name: "chat",
  props: ["api_token"],
  data() {
    return {
      messages: [],
      data: "",
      path: "ws://127.0.0.1:2346",
      socket: "",
      form: {},
    };
  },
  mounted() {
    // this.path = this.path + "/api_token=" + this.api_token;
    console.log(this.path);
    this.init();
  },
  methods: {
    onSubmit() {
      this.send();
    },
    init: function () {
      if (typeof WebSocket === "undefined") {
        alert("您的浏览器不支持socket");
      } else {
        // 实例化socket
        this.socket = new WebSocket(this.path);
        // 监听socket连接
        this.socket.onopen = this.open;
        // 监听socket错误信息
        this.socket.onerror = this.error;
        // 监听socket消息
        this.socket.onmessage = this.getMessage;
      }
    },
    open: function () {
      console.log("socket连接成功");
    },
    error: function () {
      console.log("连接错误");
    },
    getMessage: function (e) {
      // this.$message(e.data, "info");
      let data = JSON.parse(e.data);
      let type = data.type || "";
      console.log(type);
      switch (type) {
        case "init":
          this.joinChat(data);
          break;
        case "say":
          this.messages.push(data);
        case "send":
          this.messages.push(data);
        default:
          console.log(data);
      }
    },
    send: function () {
      this.socket.send(this.data);
    },
    close: function () {
      console.log("socket已经关闭");
    },
    destroyed() {
      // 销毁监听
      this.socket.onclose = this.close;
    },
    async joinChat(msg) {
      let { data } = await axios.post("/api/chat/join", msg);
    },
  },
};
</script>

<style>
.chat {
  height: 500px;
}
</style>