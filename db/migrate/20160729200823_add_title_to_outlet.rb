class AddTitleToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :title, :string
  end
end
