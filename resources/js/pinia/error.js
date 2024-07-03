import { defineStore } from "pinia";
import { ref } from "vue";

export const useErrorNormalStore = defineStore('error', () => {
    const showError = ref(false)
    const msgError = ref("")
    const colorError = ref("")
    const typeError = ref(0)

    function $reset() 
    {
       showError.value = false
       msgError.value = ""
       colorError.value = ""
       typeError.value = 0
    }

    return {
        showError,
        msgError,
        colorError,
        typeError,
        $reset
    }

})