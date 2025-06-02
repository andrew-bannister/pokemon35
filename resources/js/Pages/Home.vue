<template>
<div class="bg-sky-100 w-screen h-screen text-center flex justify-center items-center">
    <div class="grid">
        <div class="text-4xl text-center">
            <h1>Pokémon-35!</h1>
        </div>
        <div class="mt-4">
            <button class="border border-black border-4 bg-white px-3 py-1 rounded-md" @click="generatePokemon">Generate</button>
        </div>
    </div>
</div>
</template>

<script>

import axios from "axios";

export default {
    data() {
        return {

        }
    },
    methods: {
        generatePokemon() {
            axios.get('/get-random-pokemon').then(response => {
                let pokemonArray = response.data.pokemon;

                pokemonArray.forEach(pokemon => console.log(pokemon.name));
            });
        }
    }
}
</script>