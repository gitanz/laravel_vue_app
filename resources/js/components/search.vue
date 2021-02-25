<template>
    <div>
        <div class="container mt-5" >

            <form id="stock" action="#">
                <div class="form-group">
                    <label>Stock Symbol</label>
                    <div class="input-group mb-3">
                        <input type="text" id="stock-symbol" v-on:keyup="getSuggestions" v-model="symbol" class="form-control" placeholder="Enter Stock Symbol">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" @click="getStockInformation">Get Price</button>
                        </div>
                    </div>

                    <div id="suggestions-wrapper" v-if="suggestions.length > 0">
                        <ul id="suggestions" class="list-group" style="height:200px; overflow-y:auto;">
                            <li class="list-group-item" v-for="suggestion in suggestions" @click="setSuggestion(suggestion)">
                                {{suggestion.name}} <strong>{{suggestion.symbol}}</strong>
                            </li>
                        </ul>
                    </div>


                    <div id="result">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td data-name="symbol">Symbol</td>
                                <td data-name="open">Open</td>
                                <td data-name="high">High</td>
                                <td data-name="low">Low</td>
                                <td data-name="price">Price</td>
                                <td data-name="volume">Volume</td>
                                <td data-name="latest_trading_day">Latest Trading Day</td>
                                <td data-name="previous_close">Previous Close</td>
                                <td data-name="change">Change</td>
                                <td data-name="change_percent">Change(%)</td>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-if="information">
                                    <td> {{information.symbol}}</td>
                                    <td> {{information.open}}</td>
                                    <td> {{information.high}}</td>
                                    <td> {{information.low}}</td>
                                    <td> {{information.price}}</td>
                                    <td> {{information.volume}}</td>
                                    <td> {{information.latest_trading_day}}</td>
                                    <td> {{information.previous_close}}</td>
                                    <td> {{information.change}}</td>
                                    <td> {{information.change_percent}}</td>
                                </tr>
                                <tr v-else>
                                    <td colspan="10">No informtion found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
export default {
    name: "search",
    data: function(){
        return {
            symbol: "",
            suggestions: [],
            information: false
        }
    },
    methods: {
        setSuggestion: function(suggestion){
            this.symbol = suggestion.symbol;
            // this.symbol = event.target.closest('li').getAttribute('data-symbol');
            this.suggestions = [];
        },
        getSuggestions: function(){
            let $this = this;
            axios.post('/api/search-symbol', {
                'stock-symbol': $this.symbol
            }).then(function (response) {
                $this.suggestions = response.data
            }).catch(function (error) {
                    console.log(error);
            });
        },
        getStockInformation: function(){
            let $this = this;
            axios.post('/api/stock-quote', {
                'stock-symbol': $this.symbol
            }).then(function (response) {
                $this.information = response.data.data
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>

</style>
