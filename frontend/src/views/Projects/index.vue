<template>
  <InnerPageHero image-url="/images/image-3.jpg" title="Projects" />

  <div class="container mx-auto px-4 sm:px-0 py-8 sm:py-20">
    <Projects layout="grid" :show-view-all="false" :projects="projects.data" />

    <div class="mt-8 sm:mt-12">
      <button class="px-4 py-2 sm:px-6 bg-primary text-white rounded focus:outline-none"
              @click="showMoreProjects"
              v-if="projects.links.next!==null">
        <span v-if="loading">Loading...</span>
        <span v-else>View More</span>
      </button>
    </div>
  </div>
</template>

<script>
import InnerPageHero from "@/components/InnerPageHero";
import Projects from "@/components/Projects";
import { useProject } from "@/composables/useProject.js";

export default {
  components: {
    InnerPageHero,
    Projects,
  },

  props: {},

  setup() {
    let { fetchProjects, loading, projects } = useProject();

    fetchProjects();

    function showMoreProjects() {
      fetchProjects({
        showMore: true,
        page: projects.value.meta.current_page + 1
      });
    }

    return {
      projects,
      loading,
      showMoreProjects,
    };
  },
};
</script>