class AddZohoExportedToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :zoho_exported, :boolean, :default => false
  end
end
