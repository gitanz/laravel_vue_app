<template>
    <div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Three Test</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item pl-4">
                        <router-link to="/">Search</router-link>
                    </li>
                    <li class="nav-item pl-4">
                        <router-link to="/history">History</router-link>
                    </li>
                </ul>
                <button class="btn btn-outline-success my-2 my-sm-0" v-if="loggedIn" v-on:click="logoutFacebook">
                    {{ logoutText }}
                </button>
                <button class="btn btn-outline-success my-2 my-sm-0" v-else v-on:click="loginFacebook">{{ loginText }}
                </button>
            </div>
        </nav>
        <div id="login"></div>
        <login v-if="!loggedIn" v-on:loginFromPage="onLoginFromPage"></login>
<!--        <search v-else></search>-->
        <router-view v-else></router-view>
    </div>
</template>

<script>
const default_layout = "default";

export default {
    name: "app.vue",
    data: function () {
        return {
            loginText: "Login",
            logoutText: "Logout",
            loggedIn: false,
            loggedInUserName: "",
        }
    },
    mounted: function () {
        let $this = this;
        window.fbAsyncInit = function () {
            FB.init({
                appId: '3814027855330782',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v10.0'
            });
            console.log("initialized")
            FB.getLoginStatus(function (response) {
                $this.statusChangedCallback(response)
            }, true);

        };
    },
    methods: {
        'onLoginFromPage': function(response){
            this.statusChangedCallback(response);
        },
        "statusChangedCallback": function (response) {
            console.log("change callback called");
            if (response.status === 'connected') {
                this.loggedIn = true
                FB.api('/me', function (response) {
                    this.loggedInUserName = response.name;
                });
            } else {
                this.loggedIn = false
            }
        },
        "loginFacebook": function (event) {
            let $this = this;
            FB.login(function (response) {
                $this.statusChangedCallback(response);
            });
        },
        "logoutFacebook": function () {
            let $this = this
            FB.logout(function (response) {
                $this.statusChangedCallback(response)
            });
        }
    }

}


</script>

<style scoped>

</style>
