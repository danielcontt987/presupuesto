<template>
    <v-card class="card-container" flat>
        <div class="card-inner">
            <!-- Frente -->
            <v-card class="card-front pa-4" color="blue-darken-3" dark rounded="xl">
                <v-row>
                    <v-col cols="3">
                        <v-sheet class="chip" rounded></v-sheet>
                    </v-col>
                    <v-col cols="9" class="text-right">
                        <h3 class="font-weight-bold">BBVA</h3>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <h4 class="number">1234 5678 9012 3456</h4>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col>
                        <small>Cardholder</small>
                        <p class="font-weight-bold">JUAN P PEREZ</p>
                    </v-col>
                    <v-col class="text-right">
                        <small>Validez</small>
                        <p class="font-weight-bold">09/28</p>
                    </v-col>
                </v-row>
            </v-card>
        </div>
    </v-card>
</template>
<style scoped>
.card-container {
    perspective: 1000px;
    cursor: pointer;
    width: 340px;
    height: 210px;
}

.card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transform-style: preserve-3d;
    transition: transform 0.8s;
}



/* Caras */
.card-front,
.card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    background: linear-gradient(135deg, #002f6c, #0056b3, #007bff);
}

.card-front {
    transform: rotateY(0deg);
}

.card-back {
    transform: rotateY(180deg);
}

/* Estilos adicionales */
.chip {
    width: 50px;
    height: 35px;
    background: silver;
}

.number {
    letter-spacing: 2px;
    font-weight: bold;
}

.magnetic-strip {
    background: black;
    height: 40px;
    border-radius: 4px;
}

.signature {
    background: white;
    color: black;
    height: 40px;
    font-size: 0.8rem;
}

.cvv {
    background: white;
    color: black;
    font-weight: bold;
    padding: 6px;
}

.bank-name {
    position: absolute;
    bottom: 10px;
    left: 15px;
    font-size: 0.9rem;
}
</style>