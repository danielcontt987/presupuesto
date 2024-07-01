<template>
    <v-avatar variant="tonal" color="fail" size="100">
        <!-- <div class="circle-check pt-6">
            <svg
                class="checkmark"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 52 52"
            >
                <circle
                    class="checkmark-circle"
                    cx="26"
                    cy="26"
                    r="25"
                    fill="none"
                />
                <path
                    class="checkmark-check"
                    fill="none"
                    d="M14.1 27.2l7.1 7.2 16.7-16.8"
                />
            </svg>
        </div> -->
        <div class="circle-error pt-6">
            <svg
                class="crossmark"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 52 52"
            >
                <circle
                    class="crossmark-circle"
                    cx="26"
                    cy="26"
                    r="25"
                    fill="none"
                />
                <path
                    class="crossmark-cross"
                    fill="none"
                    d="M16 16 36 36 M36 16 16 36"
                />
            </svg>
        </div>
    </v-avatar>
</template>
<style scoped>

.alert {
    position: relative;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
    animation: fadeIn 0.5s ease-out;
}

.alert-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.circle-error {
    margin-bottom: 20px;
}

.crossmark {
    width: 72px;
    height: 72px;
}

.crossmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke: #f44336;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards, fill 0.4s ease-in-out 0.4s forwards;
}

.crossmark-cross {
    transform-origin: 50% 50%;
    stroke-dasharray: 44;
    stroke-dashoffset: 44;
    stroke-width: 2;
    stroke: #f44336;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
}

.alert p {
    font-size: 1rem;
    margin-bottom: 20px;
}

.alert-button {
    padding: 10px 20px;
    border: none;
    background-color: #f44336;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.alert-button:hover {
    background-color: #e53935;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

</style>
