<template>
    <div class="card-body p-3">
        <form
            class="form-horizontal form-simple"
            method="POST"
            action="/login"
            id="login-form"
            @submit.prevent="SubmitForm()"
        >
            <fieldset class="form-group position-relative has-icon-left mb-0">
                <input name="_token" type="hidden" :value="getCrf" />
                <input type="hidden" name="access_token" id="access_token" />
                <input type="hidden" name="login_type" value="email" />
                <input
                    name="email"
                    type="text"
                    v-model="form.email"
                    @change="CheckEmail"
                    class="form-control form-control-lg input-lg"
                    id="user-name"
                    placeholder="email@example.com"
                />
                <div class="form-control-position">
                    <i class="ft-user"></i>
                </div>
            </fieldset>
            <fieldset class="form-group position-relative has-icon-left">
                <input
                    name="password"
                    type="password"
                    v-model="form.password"
                    class="form-control form-control-lg input-lg"
                    id="user-password"
                    placeholder="type your password"
                    required
                />
                <div class="form-control-position">
                    <i class="la la-key"></i>
                </div>
            </fieldset>
            <div class="form-group">
                <span class="text-danger" v-if="error">
                    {{ error }}
                </span>
            </div>
            <button
                type="submit"
                class="btn btn-lg btn-block"
                style="background: #143b64 !important; color: white"
            >
                <span class="">
                <i class="ft-unlock"></i>
                <span class="mx-2">
                        {{trans.login}}
                    </span>
                </span>
            </button>
        </form>
    </div>
</template>
<script>
// import {Auth} from 'firebase/auth';
import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
export default {
    name: "EmailLogin",
    data() {
        return {
            form: {
                email: "",
                password: "",
                // access_token: '',
            },
            error: "",
                trans: window.lang[window.localStorage.getItem('local') ?? 'ar'],
            // scrf: getCrf(),
        };
    },
    created(){
        console.log(this.trans.login);
    },
    computed: {
        getCrf() {
            return document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
        },
    },
    methods: {
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
        SubmitForm() {
            console.log(this.form);
            const auth = getAuth();
            // auth.languageCode = 'it';
            signInWithEmailAndPassword(
                auth,
                this.form.email,
                this.form.password
            )
                .then((userCredential) => {
                    // Signed in
                    const user = userCredential.user;
                    console.log("user Login Success Fule");
                    this.form.access_token = user.accessToken;
                    console.log(user);
                    console.log(this.form.access_token);
                    document.getElementById("access_token").value =
                        user.accessToken;
                    document.getElementById("login-form").submit();
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    console.log(errorCode);
                    console.log(errorMessage);
                    // ..
                    if (errorCode == "auth/wrong-password") {
                        this.error = "Worng Password";
                    } else if (errorCode == "auth/user-not-found") {
                        this.error = "Invalid Credentials";
                    } else {
                        this.error = "Invalid Credentials";
                    }
                });
        },
    },
};
</script>
