<template>
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-8 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-content"></div>
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <div class="p-1 text-center">
                            <div
                                class="d-flex align-items-center justify-content-center pt-2"
                            >
                                <img
                                    src="https://app.fastersaudi.com/uploads/logos/logo.png"
                                    style="width: 100px"
                                    alt="branding logo"
                                />
                            </div>
                        </div>
                        <h6
                            class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"
                        >
                            <span> {{ trans.register }}</span>
                        </h6>
                    </div>

                    <div class="card-body py-1">
                        <form
                            class=""
                            method="POST"
                            action="/login"
                            id="login-form"
                            @submit.prevent="SubmitForm()"
                        >
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">{{ trans.name }}</label>
                                    <fieldset
                                        class="form-group position-relative mb-0"
                                    >
                                        <input
                                            name="_token"
                                            type="hidden"
                                            :value="getCrf"
                                        />
                                        <input
                                            type="hidden"
                                            name="access_token"
                                            id="access_token"
                                        />
                                        <input
                                            type="hidden"
                                            name="login_type"
                                            value="email"
                                        />
                                        <input
                                            name="email"
                                            type="text"
                                            v-model="form.name"
                                            class="form-control form-control-sm"
                                            id="user-name"
                                            placeholder="email@example.com"
                                        />
                                    </fieldset>
                                </div>

                                <div class="col-md-6">
                                    <label for="">{{ trans.email }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <input
                                            name="email"
                                            type="email"
                                            v-model="form.email"
                                            class="form-control form-control-sm"
                                            id="user-password"
                                            placeholder="type your email"
                                            required
                                        />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans.password }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <input
                                            name="name"
                                            type="name"
                                            v-model="form.password"
                                            class="form-control form-control-sm"
                                            id="user-password"
                                            placeholder="type your password"
                                            required
                                        />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans.phone }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <input
                                            name="phone"
                                            type="phone"
                                            v-model="form.phone"
                                            class="form-control form-control-sm"
                                            id="user-password"
                                            placeholder="type your password"
                                            required
                                        />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans.address }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <input
                                            name="phone"
                                            type="phone"
                                            v-model="form.address"
                                            class="form-control form-control-sm form-control-sm"
                                            id="user-password"
                                            placeholder="type your password"
                                            required
                                        />
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans.area }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <select
                                            name="area_id"
                                            id="area_id"
                                            style="width: 100%"
                                            class="form-control form-control-sm"
                                            v-model="form.area_id"
                                            @change="getSubAreas()"
                                        >
                                            <option
                                                v-for="i in areas"
                                                :key="i.value"
                                                :value="i.id"
                                            >
                                                {{ i.name }}
                                            </option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans.sub_area }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <select
                                            name="client-type"
                                            style="width: 100%"
                                            class="form-control form-control-sm"
                                            v-model="form.sub_area_id"
                                        >
                                            <option
                                                v-for="i in sub_areas"
                                                :key="i.value"
                                                :value="i.id"
                                            >
                                                {{ i.name }}
                                            </option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{
                                        trans.client_type
                                    }}</label>
                                    <fieldset
                                        class="form-group position-relative"
                                    >
                                        <select
                                            name="client-type"
                                            style="width: 100%"
                                            class="form-control form-control-sm"
                                            v-model="form.client_type"
                                        >
                                            <option value="noraml">
                                                {{ trans.normal }}
                                            </option>
                                            <option value="company">
                                                {{ trans.company }}
                                            </option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="text-danger" v-if="error">
                                    {{ error }}
                                </span>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-lg btn-block"
                                style="
                                    background: #143b64 !important;
                                    color: white;
                                "
                            >
                                <span class="">
                                    <i class="ft-unlock"></i>
                                    <span class="mx-2">
                                        {{ trans.register }}
                                    </span>
                                </span>
                            </button>
                            <div class="mt-2">
                                <a href="/login" class="mt-3 fs-19">{{
                                    trans.has_account
                                }}</a>
                            </div>
                        </form>
                    </div>
                    <!-- <a> {}</a> -->
                </div>
            </div>
        </div>
    </div>
    <!-- </v-content>
    </v-app> -->
</template>
<script>
import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";
import Swal from "sweetalert2";
import EmailLogin from "./EmailLogin.vue";
// import EmailLogin from "./EmailLogin.vue";
import PhoneLogin from "./PhoneLogin.vue";
export default {
    name: "Register",
    components: { EmailLogin, PhoneLogin },
    data: () => ({
        cureent_page: "email",
        img: "http://localhost:8000/uploads/logos/ZmlnAW2N0To93TQU4CZNqdPYorkDaVLgCsebsjLj.png",
        trans: window.lang[window.localStorage.getItem("local") ?? "ar"],
        form: {
            name: "mohammed",
            email: "jksa@gmail.com",
            password: "jksa_21343",
            phone: "0915477450",
            area_id: "1",
            client_type: "company",
            sub_area_id: "1",
            address: "company",
        },
        error: "",
        areas: [],
        sub_areas: [],
        errors: [],
    }),

    created() {
        console.log(this.trans.login);
        this.getAreas();
    },
    computed: {
        getCrf() {
            return document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
        },
    },
    methods: {
        getAreas() {
            return axios.get("/api/global/getAllAreas").then((res) => {
                res.data.data.forEach((element) => {
                    this.areas.push({ name: element.name, id: element.id });
                });
                console.log(this.areas);
            });
        },
        CheckEmail() {
            this.validateEmail(this.form.email);
            //  console.log(this.errors);
        },
        validateEmail(value) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
                this.error = "";
            } else {
                this.error = "Email Is In Valid";
            }
        },
        getSubAreas(e) {
            // console.log(e.target.value);
            let id = document.getElementById("area_id").value;
            axios
                .post("/api/global/getSubAreaByAreaId", { area_id: id })
                .then((res) => {
                    res.data.data.forEach((element) => {
                        this.sub_areas.push({
                            name: element.name,
                            id: element.id,
                        });
                    });
                    console.log(this.sub_areas);
                });
        },
        isEmpty(obj) {
            return !Object.values(obj).some((element) => element !== null);
        },
        SubmitForm() {
            console.log(this.form);
            const auth = getAuth();
            // console.log();
            console.log(this.form);
            // if(this.)
            if (this.isEmpty(this.form)) {
                if (this.form.phone != null && this.form.email != null) {
                    this.ErrorNotification();
                }
            }
            // this.AuthWithServer(this.form);
            //  Auth With Firebase

            // const auth = getAuth();
            auth.languageCode = "it";
            createUserWithEmailAndPassword(
                auth,
                this.form.email,
                this.form.password
            )
                .then((userCredential) => {
                    // console.log
                    this.form.userCredential = userCredential;
                    this.AuthWithServer(this.form);
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    // const
                    Swal.fire({
                        title: "Error!",
                        text: trans.error_exception,
                        icon: "error",
                        confirmButtonText: "Cool",
                    });
                    // ..
                });

            // Auth With Server
        },
        AuthWithServer(form) {
            // set vairbale
            form.password_confirmation = form.password;
            form.message_token = "Client Login";
            form.fullname = form.name;

            axios
                .post("/api/client/clientRegister", form, {
                    Accept: "application/json",
                })
                .then((res) => {
                    // console.log();
                    if (res.data.status == true) {
                        // this.SubmitLaravelForm();
                        const user = form.userCredential.user;
                        console.log("user Login Success Fule");
                        this.form.access_token = user.accessToken;
                        console.log(user);
                        console.log(this.form.access_token);
                        document.getElementById("access_token").value =
                            user.accessToken;
                        document.getElementById("login-form").submit();
                    }
                })
                .catch((error) => {
                    console.log(error.response.data, error.message, error);
                    this.ErrorNotification();
                });
        },
        SubmitLaravelForm() {
            console.log("Go");
        },
        ErrorNotification() {
            Swal.fire({
                title: "Error!",
                text: "Please Confirm To Your Data",
                icon: "error",
                confirmButtonText: "Ok",
            });
        },
    },
};
</script>
