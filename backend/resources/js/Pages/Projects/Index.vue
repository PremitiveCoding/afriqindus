<template>
  <app-layout>
    <template #header>
      <Breadcrumbs :items="breadcrumbs" />
    </template>

    <Container>
      <jet-button :href="route('projects.create')">Add new</jet-button>

      <Card class="mt-4">
        <AppTable :headers="headers"
                  :items="projects">
          <tr v-for="project in projects.data"
              :key="project.id">
            <td>{{ project.title }}</td>
            <td>{{ project.category.name }}</td>
            <td>{{ project.created_at_for_human }}</td>
            <td>
              <div class="flex items-center justify-end space-x-2">
                <EditBtn :url="route('projects.edit', {project: project.id})" />
                <DeleteBtn :url="route('projects.destroy', {project: project.id})"
                           module-name="project" />
              </div>
            </td>
          </tr>
        </AppTable>
      </Card>
    </Container>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import EditBtn from "@/Components/EditBtn";
import DeleteBtn from "@/Components/DeleteBtn";
import SimplePagination from "@/Components/SimplePagination";
import AppTable from "@/Components/Table";
import Container from "@/Components/Container";
import Card from "@/Components/Card";
import Breadcrumbs from "@/Components/Breadcrumbs";
import JetButton from "@/Jetstream/Button";

export default {
  props: {
    projects: {},
  },

  components: {
    AppLayout,
    EditBtn,
    DeleteBtn,
    SimplePagination,
    AppTable,
    JetButton,
    Container,
    Card,
    Breadcrumbs,
  },

  computed: {
    headers() {
      return [
        {
          name: "Title",
        },
        {
          name: "Category",
        },
        {
          name: "Created Date",
        },
        {
          name: "Action",
          class: "text-right",
        },
      ];
    },

    breadcrumbs() {
      return [
        {
          label: "Projects",
        },
      ];
    },
  },
};
</script>
