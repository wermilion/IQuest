<script setup lang="ts">
import { ref } from "vue";

const linksSocial = ref([
  {
    link: "https://vk.com/iquest",
    img: "vk.svg",
  },
  {
    link: "https://t.me/questtomsk",
    img: "telegram.svg",
  },
  {
    link: "https://www.youtube.com/channel/UCiEXe3D9fy8GX9X73lpxOxA?disable_polymer=true",
    img: "youtube.svg",
  },
]);

const linkASAP = ref("https://asapeducation.ru/?utm_course=iquest_site");

const contacts = ref([
  {
    text: "94-29-10",
    img: "phone.svg",
  },
  {
    text: "iquest.tsk@gmail.com",
    img: "mail.svg",
  },
]);
</script>

<template>
  <footer class="border">
    <div class="container footer">
      <img src="/logo/logo_full.svg" alt="logo" />
      <div class="footer-links">
        <div class="footer-links__contacts">
          <span v-for="info in contacts" :key="info.text" class="body">
            <img :src="`/icons/${info.img}`" :alt="info.img" /> {{ info.text }}
          </span>
        </div>
        <div class="footer-links__social">
          <a
            v-for="link in linksSocial"
            :key="link.img"
            target="_blank"
            :href="link.link"
          >
            <img :src="`/icons/social/${link.img}`" :alt="link.img" />
          </a>
        </div>
      </div>
      <div class="footer-privacy">
        <p class="smallFootnote">Политика конфиденциальности</p>
        <span class="smallFootnote">
          Разработано в
          <a :href="linkASAP" target="_blank"
            ><img src="/logo/asapLogo.svg" alt="asapLogo"
          /></a>
        </span>
      </div>
    </div>
  </footer>
</template>

<style scoped lang="scss">
.border {
  border-top: 2px solid $color-shade-6;

  background-image: url("/gradient/footer-gradient.svg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: right bottom;
}
.footer {
  height: 100%;
  margin-inline: auto;
  padding: 72px 88px;
  justify-content: space-between;
  max-height: 282px;

  &-links {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &__contacts {
      display: flex;
      flex-direction: column;
      gap: 12px;

      span {
        display: flex;
        gap: 8px;
        color: $color-base2;
      }
    }

    &__social {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }
  }

  &-privacy {
    justify-content: space-between;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    color: $color-base2;

    span {
      display: flex;
      align-items: center;
      gap: 8px;
    }
  }
}
</style>
