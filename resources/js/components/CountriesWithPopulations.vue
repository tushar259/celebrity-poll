<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Population</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(country, index) in countries" :key="index" :class="index % 2 === 0 ? 'even-row' : 'odd-row'">
                            <td>{{ country.name }}</td>
                            <td>{{ formatNumber(country.population) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Population</h5>
                        <p class="card-text">{{ formatNumber(totalPopulation) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                countries: [],
                totalPopulation: 0,
            }
        },

        created(){
            // this.getCountriesInfoFromApi();
            this.getCountriesInfoFromController();
        },

        methods: {
            formatNumber(number) {
                return number.toLocaleString();
            },

            getCountriesInfoFromApi(){
                axios.get('https://restcountries.com/v3.1/all')
                .then(response => {
                    console.log(response);
                    const countries = response.data.map(country => ({
                        name: country.name.common,
                        population: country.population,
                    }));

                    const totalPopulation = countries.reduce((total, country) => total + country.population, 0);

                    console.log('Countries:', countries);
                    console.log('Total Population:', totalPopulation);
                })
                .catch(error =>{
                    console.log('Error: ',error);
                });
            },

            getCountriesInfoFromController(){
                axios.get('/api/show-country-list')
                .then(response =>{
                    console.log(response);
                    response.data.countries_list.forEach(item => {
                        this.totalPopulation += item.population;
                        this.countries.push(item);
                    });
                })
                .catch(error =>{

                });
            }
        }
    }
</script>
