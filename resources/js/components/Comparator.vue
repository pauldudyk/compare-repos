<template>
    <div class="container grid-list-md text-xs-center">
        <h2 class="display-3 font-weight-thin">Compare two repos</h2>
        <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>
                <v-flex xs6>
                    <v-card flat color="grey lighten-5">
                        <v-text-field v-model="firstPackage" :rules="firstPackageRules" label="First package" required></v-text-field>                
                    </v-card>
                    <v-alert v-if="firstPackageData.status=='error'" :value="true" type="error" > Package not found. </v-alert>
                </v-flex>

                <v-flex xs6>
                    <v-card flat color="grey lighten-5">
                        <v-text-field v-model="secondPackage" :rules="secondPackageRules" label="Second package" required></v-text-field>
                    </v-card>
                    <v-alert v-if="secondPackageData.status=='error'" :value="true" type="error" > Package not found. </v-alert>
                </v-flex>
            </v-layout>

            <v-btn :disabled="!valid" :loading="loading" color="success" @click="compare">
                Compare
            </v-btn>

        </v-form>
        <v-layout row wrap v-if="loadedData">
            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Language</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.language}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.language}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Forks</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.forks}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.forks}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Stars</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.stars}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.stars}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Watchers</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.watchers}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.watchers}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Latest release date</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.last_release_date}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.last_release_date}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Open pull requests</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.open_pull_requests}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.open_pull_requests}}</v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0"><h3>Closed pull requests</h3></v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{firstPackageData.closed_pull_requests}}</v-card-text>
                </v-card>
            </v-flex>
            <v-flex xs6>
                <v-card flat color="grey lighten-5">
                <v-card-text class="px-0">{{secondPackageData.closed_pull_requests}}</v-card-text>
                </v-card>
            </v-flex> 
        </v-layout>
    </div>
</template>

<script>
    export default {
        components: {
    
        },
        data() {
            return {
                valid: true,
                firstPackage: '',
                firstPackageRules: [
                    v => !!v || 'First package is required',
                ],
                secondPackage: '',
                secondPackageRules: [
                    v => !!v || 'Second package is required',
                ],
                firstPackageData: {},
                secondPackageData: {},
                loadedData: false,
                loading: false,
            };
        },
        methods: {
            compare() {
                if (this.$refs.form.validate()) {
                    this.loadedData = false;
                    this.loading = true;
                    this.firstPackageData = {};
                    this.secondPackageData = {};
                    axios
                        .post('/comparator/find', {
                            firstPackage: this.firstPackage,
                            secondPackage: this.secondPackage
                        })
                        .then(response => {
                            this.loadedData = true;
                            this.loading = false;
                            this.firstPackageData = response.data.data[0];
                            this.secondPackageData = response.data.data[1];
                        })
                        .catch(e => {
                            this.loading = false;
                            console.log(e.response);
                        });
                }
            }
        },
        mounted() {
    
        }
    };
</script>
