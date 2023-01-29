<template>
    <h1>admin index page</h1>
    <router-link to="/">Home</router-link>

    <br>
    <button @click="logout">Log Out</button>
</template>

<script setup>
    import { useRouter } from 'vue-router';

    const router = useRouter();

    const logout = ()=>{
        localStorage.removeItem('token');
        router.push('/');
    }

</script>