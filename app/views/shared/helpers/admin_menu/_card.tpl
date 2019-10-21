{a namespace="admin" controller=$admin_controller action="edit" id=$object}{!"edit"|icon} {t}Edit product{/t}{/a}
{a namespace="admin" controller=card_cloning action="create_new" card_id=$card}{!"clone"|icon:"regular"} {t}Copy this product{/t}{/a}
{a namespace="admin" controller=$admin_controller action="create_new"}{!"plus"|icon} {t}Create new product{/t}{/a}
{a namespace="admin" controller=$admin_controller action="index"}{!"hammer"|icon} {t}Products administration{/t}{/a}
