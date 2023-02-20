<x-tests.app>
    <x-slot name="header">ヘッダー１</x-slot>
    コンポーネントテスト１
    <x-tests.card title="タイトル" content="本文" :message="$message"/>
    <x-tests.card title="タイトル２" />
    <x-tests.card title="CSSを変更しない" class="bg-red-300"/>
</x-tests.app>
