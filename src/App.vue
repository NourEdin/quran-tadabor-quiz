<template>
  <div id="app">
    <nav>
      <div class="home-label">
        <router-link to="/">الصفحة الرئيسية</router-link>
      </div>
      <router-link class="link-box"  v-for="i in 30"  :key="i" :to="'/juz/'+i" >
        <span class="juz-label">
          {{i}}
        </span>
      </router-link>
    </nav>
    <router-view/>
  </div>
</template>

<style>
.link-box {
  margin: 8px 5px;
  display: inline-block

}
.juz-label {
  padding: 5px;
  background-color: #acc2ff;
  border-radius: 4px;
}
.home-label {
  margin-bottom: 10px;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  direction: rtl;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
