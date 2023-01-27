<template>
    <div>
      <nav>
        <router-link to="/admin/dashboard">Dashboard</router-link>
        <router-link to="/admin/users">Users</router-link>
        <router-link to="/admin/cars">Cars</router-link>
        <router-link to="/admin/orders">Orders</router-link>
      </nav>
      <main>
        <router-view />
      </main>
    </div>
  </template>
  
  <script>
  export default {
    name: 'LayoutAdmin',
  };
  </script>
  
  <style>
  nav {
    background-color: #333;
    color: #fff;
    padding: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  nav a {
    color: #fff;
    text-decoration: none;
    margin-right: 1rem;
  }
  main {
    padding: 1rem;
  }
  </style>
  