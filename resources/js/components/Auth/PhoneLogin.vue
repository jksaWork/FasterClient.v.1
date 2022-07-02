<template>
    <div class="card-body py-1">

        <form action="/login" id="login-form-with-phone-number" method="post">
         <input name="_token" type="hidden" :value="getCrf" />
                <input type="hidden" name="access_token" id="access_token" />
                <input type="hidden" name="login_type" value="phoneNumber" />
                <input
                    name="phone"
                    type="hidden"
                    v-model="form.phone"
                    class="form-control form-control-lg input-lg"
                    id="user-name"
                    placeholder="Type Your Phone Number"
                />
                <br />
                <div class="form-control-position">
                    <i class="fa-solid fa-message-smile"></i>
                </div>
        </form>
        <form
            v-if="!confirem_code"
            class="form-horizontal form-simple"
            method="POST"
            action="/login"
            @submit.prevent="SubmitForm()"
        >
            <div class="" >
                <fieldset class="form-group position-relative has-icon-left mb-0">
                <!-- <input name="_token" type="hidden" :value="getCrf" /> -->
                <!-- <input type="hidden" name="access_token" id="access_token" /> -->
                <!-- <input type="hidden" name="login_type" value="phoneNumber" /> -->
                <input
                    name="phone"
                    type="text"
                    v-model="form.phone"
                    class="form-control form-control-lg input-lg"
                    id="user-name"
                    :placeholder="trans.phone_number_palace_holder"
                />
                <br />
                <div class="form-control-position">
                    <i class="fa-solid fa-message-smile"></i>
                </div>
            </fieldset>
            </div>
            <button
                id='phone-number-submit'
                type="submit"
                class="btn btn-lg btn-block"
                style="background: #143b64 !important; color: white"
            >
            <span> {{trans.send_verfiaction_code}}</span>
                <i clas s="ft-unlock"></i>
            </button>
        </form>
        <form
            v-if="confirem_code"
            class="form-horizontal form-simple"
            method="POST"
            action="/login"
            id="phone-number-icon"
            @submit.prevent="VerfiactionCode()"
        >
        <div class="text-center text-sm mb-3" style='font-weight:bold;'>
            <!-- We Have Send Verfication Code to You Check Your Inbox -->
            {{trans.we_have_send_verfiaction_code}}
        </div>
            <div class="" >
                <fieldset class="form-group position-relative has-icon-left mb-0">
                <input name="_token" type="hidden" :value="getCrf" />
                <input type="hidden" name="access_token" id="access_token" />
                <input type="hidden" name="login_type" value="phoneNumber" />
                <input
                    name="email"
                    type="text"
                    v-model="form.code"
                    class="form-control form-control-lg input-lg"
                    id="user-name"
                    :placeholder="trans.confrim_code_place_holder"
                />
                <a href="#"  @click.prevent=" confirem_code = false">
                    <span class="mt-5">{{trans.resend_code}}</span>
                </a>

                <div class="form-control-position">
                    <i class="fa-solid fa-message-smile"></i>
                </div>

            </fieldset>
            </div>
            <div class="form-group">
                <span class="text-danger" v-if="error">
                    {{ error }}
                </span>
            </div>
            <button
                type="submit"
                class="btn btn-lg btn-block mb-3"
                style="background: #143b64 !important; color: white"
            >
                <span>
                    {{trans.conforim_code}}
                </span>
                <i class="ft-unlock"></i>
            </button>
        </form>
    </div>
</template>
<script>
// import {Auth} from 'firebase/auth';
import { getAuth,  signInWithPhoneNumber , RecaptchaVerifier} from "firebase/auth";
export default {
    name: "PhoneLogin",
    data() {
        return {
            confirem_code : false,
            form: {
                phone:'',
                code : '',
            },
            trans: window.lang[window.localStorage.getItem('local') ?? 'ar'],
            error: "",
            // scrf: getCrf(),
        };
    },
    computed: {
        getCrf() {
            return document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
        },
    },
    methods: {
        VerfiactionCode(){
            // let code ='441940';
            window.confirmationResult.confirm(this.form.code).then((result) => {
  // User signed in successfully.
            const user = result.user;
            console.log(user);
            document.getElementById('access_token').value = user.accessToken;
            this.SubmitFormPhoneNumberToServe();
            }).catch((error) => {
            // User couldn't sign in (bad verification code?)
            // ...
            });
        },
        SubmitFormPhoneNumberToServe(){
            document.getElementById('login-form-with-phone-number').submit();
        },
        SubmitForm() {
            console.log(this.form);
            const auth = getAuth();
             auth.languageCode = "it";
            const appVerifier = window.recaptchaVerifier;
            window.recaptchaVerifier = new RecaptchaVerifier(
                "phone-number-submit",
                {
                    size: "invisible",
                    callback: (response) => {
                        onSignInSubmit();
                    },
                },
                auth
            );
            // let phoneNumber = '+249915477450';
            signInWithPhoneNumber(auth, '+249' + this.form.phone, appVerifier)
                .then((confirmationResult) => {
                    console.log('message sent');
                    console.log(confirmationResult);
                    window.confirmationResult = confirmationResult;
                    this.confirem_code = true;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
