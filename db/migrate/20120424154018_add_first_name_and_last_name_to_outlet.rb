class AddFirstNameAndLastNameToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :first_name, :string
    add_column :outlets, :last_name, :string
  end
end
