<template>
    <Head title="Articles" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Articles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form :action="route('search')" method="get">
                            <div class="form-group">
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control"
                                    placeholder="Search..."
                                    v-model="query"
                                />
                            </div>
                        </form>
                        <div class="mb-3" v-for="article in articles" :key="article.id">
                            <h2 v-html="article.title"></h2>
                            <p class="m-0" v-html="article.body"></p>
                            <div v-for="tag in article.tags" :key="tag">
                                <span class="badge badge-light" v-html="tag"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';
export default {
    name: 'Articles',
    data() {
       return {
           query: ''
       }
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        articles: Array,
        page: Number
    }
}

</script>
