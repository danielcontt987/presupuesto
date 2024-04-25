import { defineStore } from "pinia";
import { ref } from "vue";

export const useAlertNormalStore = defineStore('alert', () => {
    const show = ref(false)
    const msg = ref("")
    const color = ref("")
    const icon = ref("")
    const type = ref(0)

    function $reset() 
    {
       show.value = false
       msg.value = ""
       color.value = ""
       icon.value = ""
       type.value = 0
    }

    return {
        show,
        msg,
        color,
        icon,
        type,
        $reset
    }

})