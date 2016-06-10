class AddWebsiteToOutlet < ActiveRecord::Migration
  def change
    add_column :outlets, :website, :string
  end
end
