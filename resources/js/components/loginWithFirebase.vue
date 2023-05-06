<template>
    <div>
        <section class="flexbox-container">
            <!-- <snackbar ref="snackbar" baseSize="100px" :wrapClass="''" :colors="red" :holdTime="3000" :multiple="true"/> -->

            <div
                class="col-12 d-flex align-items-center justify-content-center"
            >
                <!-- <Register /> -->
                <div class="col-md-4 col-10 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-content">
                            <div
                                class="d-flex align-items-center justify-content-center pt-2"
                            >
                                <img
                                    src="https://app.fastersaudi.com/uploads/logos/logo.png"
                                    style="width: 100px"
                                    alt="branding logo"
                                />
                            </div>
                            <div class="row px-2" style="margin: 0 2px">
                                <div
                                    class="col-6 text-center p-1"
                                    @click="cureent_page = 'phone_number'"
                                >
                                    <h4
                                        :class="
                                            ' normal-head ' +
                                            (cureent_page == 'phone_number'
                                                ? 'active'
                                                : '')
                                        "
                                    >
                                        {{ trans.phone }}
                                    </h4>
                                </div>
                                <div
                                    class="col-6 text-center p-1"
                                    @click="cureent_page = 'email'"
                                >
                                    <h4
                                        :class="
                                            'normal-head ' +
                                            (cureent_page == 'email'
                                                ? 'active'
                                                : '')
                                        "
                                    >
                                        {{ trans.email }}
                                    </h4>
                                </div>
                            </div>
                            <EmialLogin v-if="cureent_page == 'email'" />
                            <PhoneLogin v-else />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- </v-content> -->
    <!-- </v-app> -->
</template>
<style scoped>
.active {
    background: #143b64;
    border-radius: 20px;
    color: #fff;
}
.normal-head {
    padding: 10px;
}
</style>
<script>
import EmialLogin from "./Auth/EmailLogin.vue";
import PhoneLogin from "./Auth/PhoneLogin.vue";
import Register from "./Auth/Register.vue";

export default {
    name: "login-container",
    components: { EmialLogin, PhoneLogin, Register },
    data: () => ({
        cureent_page: "email",
        img: "http://localhost:8000/uploads/logos/ZmlnAW2N0To93TQU4CZNqdPYorkDaVLgCsebsjLj.png",
        trans: window.lang[window.localStorage.getItem("local") ?? "ar"],
    }),
    created() {
        console.log(this.trans);
    },
    methods: {
        // ToogelFrom() {
        //     alert("Hello");
        // },
    },
    component: {
        getActiveClass: () => (cureent_page == "phone_number" ? "active" : ""),
    },
};
</script>
