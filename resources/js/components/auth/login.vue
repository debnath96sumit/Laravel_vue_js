<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Fira sans', sans-serif;
        font-size: 16px;
    }
    .login{
        background: #6c5ce7;
        padding: 0;
        margin: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
    }
    .formLogin{
        width: 220px;
        height: 301px;
        padding: 10px;
        border: 1px solid red;
    }
    input{
        background: rgba(228, 232, 243, 0.8);
        background-position: 0.5em 0.6em;
        border: none;
        color: rgba(80, 80, 80, 1);
        margin: 5px 0px;
        padding: 5px 3px;
    }

    input:hover{
        background-color: red;
    }
    .text-danger{
        color: red;
    }
</style>
<template>
    <div class="login">
        <div class="formLogin">
            <p class="text-danger" v-if="error" >{{ error }}</p>
            <form @submit.prevent="login">
                <input type="email" placeholder="Please enter your email" v-model="form.email">
                <br>
                <input type="password" placeholder="Please enter your password" v-model="form.password">
                <br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</template>

<script setup>
    import { reactive, ref } from "vue";
    import { useRouter} from "vue-router";
    const router = useRouter();
    let form = reactive({
        email:'',
        password:'',
    })

    let error = ref('');

    const login = async()=>{
        await axios.post('/api/login', form)
        .then(response =>{
            console.log(response);
            if (response.data.success) {
                localStorage.setItem('token', response.data.data.token)
                router.push('/admin/home');
            }
            else{
                error.value = response.data.messege;
            }
        })
    }
</script>