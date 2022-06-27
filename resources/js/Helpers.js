class Translation {
    getTrans(val){
        console.log(val);
        const file = localStorage.getItem('local') == 'ar' ? ARLang : ENLang;
        console.log(file[val]) ?? val;
    }
}
const trans =  new Translation();
export default trans;
