<template>
  <div>
    <Hero />

    <div class="py-8 sm:py-20 px-4 sm:px-0 container mx-auto">
      <Projects :projects="projects.data" />
    </div>
  </div>
</template>

<script>
import Hero from "./Hero.vue";
import Projects from "@/components/Projects";
import { useProject } from "@/composables/useProject.js";

export default {
  name: 'Home',

  components: {
    Hero,
    Projects,
  },

  setup() {
    let { fetchProjects, projects } = useProject();

    fetchProjects();

    return {
      projects
    };
  },
}
</script>
