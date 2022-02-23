<template>
    <navbar-component></navbar-component>
    <div class="container">
        <router-view></router-view>
    </div>
</template>
<script>
import NavbarComponent from '../components/Navbar'
export default {
    components: {
        NavbarComponent
    }
}
</script>