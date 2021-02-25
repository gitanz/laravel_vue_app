<template>
    <div>
        <div class="container mt-5">

            <h3>Login to continue</h3>

            <button v-on:click="loginFacebook" class="btn btn-primary"> Login with Facebook </button>

        </div>
    </div>

</template>

<script>
export default {
    name: "login",
    methods: {
        "loginFacebook": function (event) {
            let $this = this;
            FB.login(function (response) {
                $this.statusChangedCallback(response);
            });
        },
        "statusChangedCallback": function (response) {

            this.$emit('loginFromPage', response)
        },
    }
}
</script>

<style scoped>

</style>
