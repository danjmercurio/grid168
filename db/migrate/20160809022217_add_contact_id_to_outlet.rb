class AddContactIdToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :zoho_contact_id, :string
  end
end
