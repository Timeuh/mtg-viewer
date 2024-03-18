<script setup>
import { ref } from 'vue';
import { fetchCardsByName } from '../services/cardService';
// TODO: La page de recheche de cartes.
const search = ref('');
const cards = ref([]);
const loadingCards = ref(false);


async function searchCards() {
  if (search.value === '') {
    return;
  }
  cards.value = await fetchCardsByName(search.value);

}
</script>

<template>
    <div>
        <h1>Rechercher une Carte</h1>
        <input type="text" v-model="search"/>
      <button @click="searchCards">Rechercher</button>
    </div>


    <div class="card-list">
        <div v-if="loadingCards">Loading...</div>
        <div v-else>
            <div class="card" v-for="card in cards" :key="card.id">
                <router-link :to="{ name: 'get-card', params: { uuid: card.uuid } }"> {{ card.name }} - {{ card.uuid }} </router-link>
            </div>
        </div>
    </div>
</template>
